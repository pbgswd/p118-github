<?php

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
        //seed the data here and now
        $attachments = \App\Models\Attachment::all();
        foreach ($attachments as $attachment) {
            $file_extension = File::extension('storage/'.$attachment->subfolder.'/'.$attachment->file);
            $file_type = in_array(strtolower($file_extension), ['jpg','jpeg','png','gif','webp','svg']) ? 'image': '';
            if(strtolower($file_extension)  == 'bin'){
                $file_type = 'binary';
            }
            if(strtolower($file_extension) == 'pdf'){
                $file_type = 'pdf';
            }
            if(strtolower($file_extension) == 'zip'){
                $file_type = 'zip';
            }
            if($file_type == ''){
                $file_type = 'file';
            }

            $attachment->file_type = $file_type;
            $attachment->save();
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
