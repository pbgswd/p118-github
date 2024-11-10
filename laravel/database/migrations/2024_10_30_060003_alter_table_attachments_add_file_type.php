<?php

use App\Models\Attachment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->string('file_type')->after('file')->nullable();
        });

        $attachments = Attachment::where('file_type', null)->get();

        $fileTypes = [
            'pdf' => 'pdf',
            'zip' => 'zip',
            'bin' => 'binary',
        ];

        foreach ($attachments as $att) {
            $file_extension = strtolower(File::extension('storage/' . $att->subfolder . '/' . $att->file));
            $file_type = $fileTypes[$file_extension] ?? (
            in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']) ? 'image' : 'file'
            );

            $att->update(['file_type' => $file_type]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropColumn('file_type');
        });
    }
};
