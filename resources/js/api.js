/**
 * STOMAN API wrapper with JWT Authentication & Backend Integration.
 */

const MOCK = false;

const csrf = () => document.querySelector('meta[name="csrf-token"]')?.content;
export const getJwtToken = () => localStorage.getItem('stoman_jwt_token');
export const setJwtToken = (token) => {
    if (token) {
        localStorage.setItem('stoman_jwt_token', token);
    } else {
        localStorage.removeItem('stoman_jwt_token');
    }
};

async function request(method, url, body = null) {
    const token = getJwtToken();
    const headers = {
        Accept: 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        ...(csrf() ? { 'X-CSRF-TOKEN': csrf() } : {}),
        ...(token ? { Authorization: `Bearer ${token}` } : {}),
        ...(body && !(body instanceof FormData) ? { 'Content-Type': 'application/json' } : {}),
    };

    const options = {
        method,
        headers,
        ...(body ? { body: body instanceof FormData ? body : JSON.stringify(body) } : {}),
    };

    const res = await fetch(url, options);

    if (res.status === 401 && !url.includes('/api/auth/login') && !url.includes('/api/auth/register')) {
        setJwtToken(null);
    }

    if (!res.ok) {
        let errData = {};
        try {
            errData = await res.json();
        } catch (_) {}
        const error = new Error(errData.message || `Request failed: ${res.status}`);
        error.status = res.status;
        error.data = errData;
        throw error;
    }

    return res.status === 204 ? null : res.json();
}

export const api = {
    getJwtToken,
    setJwtToken,

    // Authentication with JWT
    login: async (credentials) => {
        const res = await request('POST', '/api/auth/login', credentials);
        if (res?.access_token) {
            setJwtToken(res.access_token);
        }
        return res;
    },

    register: async (payload) => {
        const res = await request('POST', '/api/auth/register', payload);
        if (res?.access_token) {
            setJwtToken(res.access_token);
        }
        return res;
    },

    logout: async () => {
        try {
            await request('POST', '/api/auth/logout');
        } finally {
            setJwtToken(null);
            window.location.href = '/login';
        }
    },

    me: () => request('GET', '/api/auth/me'),

    /** List items in a folder or filter */
    list: (params = {}) => {
        const query = new URLSearchParams(params).toString();
        return request('GET', `/api/items${query ? `?${query}` : ''}`);
    },

    /**
     * Upload one file with progress reporting and optional folderId.
     */
    upload: (file, { onProgress, folderId } = {}) => {
        const formData = new FormData();
        formData.append('file', file);
        if (folderId) {
            formData.append('folder_id', folderId);
        }

        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/api/files');
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            const token = getJwtToken();
            if (token) {
                xhr.setRequestHeader('Authorization', `Bearer ${token}`);
            }

            const csrfToken = csrf();
            if (csrfToken) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            }

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable && onProgress) {
                    onProgress(Math.round((e.loaded / e.total) * 100));
                }
            };

            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        resolve(JSON.parse(xhr.responseText));
                    } catch (_) {
                        resolve();
                    }
                } else {
                    let errMessage = 'Upload failed';
                    try {
                        const parsed = JSON.parse(xhr.responseText);
                        if (parsed.message) errMessage = parsed.message;
                    } catch (_) {}
                    reject(new Error(errMessage));
                }
            };

            xhr.onerror = () => reject(new Error('Network error during upload'));
            xhr.send(formData);
        });
    },

    createFolder: (payload) => request('POST', '/api/folders', payload),
    rename: (id, name) => request('PATCH', `/api/items/${id}`, { name }),
    move: (ids, targetId) => request('POST', '/api/items/move', { ids, target: targetId }),
    star: (id, starred) => request('PATCH', `/api/items/${id}/star`, { starred }),
    share: (id, payload) => request('POST', `/api/items/${id}/shares`, payload),
    archive: (ids) => request('POST', '/api/items/archive', { ids }),
    destroy: (ids) => request('DELETE', '/api/items', { ids }),
    restore: (ids) => request('POST', '/api/items/restore', { ids }),
    emptyTrash: () => request('POST', '/api/items/trash/empty'),
};
