<?php

namespace Database\Seeders;

use App\Models\FileItem;
use App\Models\Folder;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
            ]
        );

        // Ensure user password is known
        $user->update(['password' => Hash::make('password')]);

        // Seed some sample folders if none exist
        if (Folder::where('user_id', $user->id)->count() === 0) {
            $f1 = Folder::create([
                'user_id' => $user->id,
                'name' => 'Documents',
                'color' => 'primary',
                'is_starred' => true,
            ]);

            $f2 = Folder::create([
                'user_id' => $user->id,
                'name' => 'Projects',
                'color' => 'violet',
                'is_starred' => true,
            ]);

            $f3 = Folder::create([
                'user_id' => $user->id,
                'name' => 'Assets & Images',
                'color' => 'sky',
            ]);

            // Seed sample files
            $sampleDir = "uploads/{$user->id}";
            Storage::disk('local')->makeDirectory($sampleDir);

            $files = [
                ['name' => 'Project-Roadmap.pdf', 'mime' => 'application/pdf', 'size' => 2450000, 'folder_id' => $f2->id, 'starred' => true],
                ['name' => 'Q4-Financial-Report.xlsx', 'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'size' => 1240000, 'folder_id' => $f1->id, 'starred' => false],
                ['name' => 'Brand-Guidelines-2026.pdf', 'mime' => 'application/pdf', 'size' => 4500000, 'folder_id' => $f3->id, 'starred' => true],
                ['name' => 'Meeting-Notes.docx', 'mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'size' => 340000, 'folder_id' => null, 'starred' => false],
                ['name' => 'Architecture-Diagram.png', 'mime' => 'image/png', 'size' => 980000, 'folder_id' => null, 'starred' => true],
            ];

            foreach ($files as $f) {
                $filePath = "{$sampleDir}/{$f['name']}";
                if (! Storage::disk('local')->exists($filePath)) {
                    Storage::disk('local')->put($filePath, "Sample content for {$f['name']}");
                }

                FileItem::create([
                    'user_id' => $user->id,
                    'folder_id' => $f['folder_id'],
                    'name' => $f['name'],
                    'path' => $filePath,
                    'mime_type' => $f['mime'],
                    'size' => $f['size'],
                    'is_starred' => $f['starred'],
                ]);
            }
        }
    }
}
