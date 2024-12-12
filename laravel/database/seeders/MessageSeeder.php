<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.  php artisan db:seed --class=MessageSeeder
     */
    public function run(): void
    {

        //Message::factory()->count(1)->create();


        $messages = array(
        array('id' => '2','source_url' => 'http://bednar.com/aliquam-eaque-voluptas-nobis.html','subject' => 'message Voluptate qui ex et.','slug' => 'message-voluptate-qui-ex-et','content' => 'content Dolores dolor dicta expedita nobis dolore. Excepturi consequatur eaque voluptates sapiente hic vitae illum. Voluptatem sunt unde corrupti natus cupiditate ea.

        Et eos asperiores molestiae. Officia placeat rem quidem possimus eligendi est. Consectetur sint in magnam quia. Est dolores natus ut neque quo dolorum accusantium.

        Atque dolorem et et corrupti vitae quod error non. Quisquam consequatur eos quos et. Non voluptatum quia est dicta nemo.

        Recusandae ullam itaque id corrupti asperiores rem veritatis eos. Voluptas molestiae sunt commodi illum. Saepe rem unde dolorem incidunt porro quia non. Non ut quos aut dolor alias.','user_id' => '1','count' => '0','state' => 'not_sent','created_at' => '2024-12-12 07:11:56','updated_at' => '2024-12-12 07:11:56'),
        array('id' => '3','source_url' => 'http://www.satterfield.net/','subject' => 'message Commodi minima animi voluptatum molestias.','slug' => 'message-commodi-minima-animi-voluptatum-molestias','content' => 'content Laboriosam non voluptas ut accusantium sunt. Eos necessitatibus est est soluta magnam et consequatur.

        Ea eos omnis et accusantium molestiae libero et. Facere ullam expedita aliquam ut odit est. Accusantium commodi ut nisi nulla corporis. Cumque et non architecto.

        Aut similique molestiae inventore numquam error. Quibusdam odit minima dolorum nostrum esse. Ducimus sed id maiores sed ducimus voluptates maxime omnis. Dolore est ut error.

        Sunt qui dolores dignissimos similique quo et aut. Ut enim ut aut nesciunt quibusdam qui. Reprehenderit quis pariatur perferendis qui repudiandae. Rem saepe sequi vel molestias neque.','user_id' => '1','count' => '0','state' => 'not_sent','created_at' => '2024-12-12 07:13:49','updated_at' => '2024-12-12 07:13:49')
        );

        foreach($messages as $msg)
        {
            DB::table('messages')->insert([
                'source_url' => $msg['source_url'],
                'subject' => "xxx" . $msg['subject'],
                'slug' => "xxx" . $msg['slug'],
                'content' => $msg['content'],
                'user_id' => $msg['user_id'],
                'count' => $msg['count'],
                'state' => $msg['state'],
                'created_at' => $msg['created_at'],
                'updated_at' => $msg['updated_at'],
            ]);
        }

        $message_categories = array(
            array('id' => '2','message_id' => '5','type' => 'model','name' => 'Message','created_at' => '2024-12-12 07:26:17','updated_at' => '2024-12-12 07:26:17'),
            array('id' => '3','message_id' => '4','type' => 'model','name' => 'Message','created_at' => '2024-12-12 07:26:40','updated_at' => '2024-12-12 07:26:40'),
            array('id' => '4','message_id' => '3','type' => 'model','name' => 'Message','created_at' => '2024-12-12 07:27:02','updated_at' => '2024-12-12 07:27:02'),
            array('id' => '5','message_id' => '2','type' => 'model','name' => 'Message','created_at' => '2024-12-12 07:27:20','updated_at' => '2024-12-12 07:27:20')
        );

        foreach($message_categories as $mc)
        {
            DB::table('message_categories')->insert([
                'message_id' => $mc['message_id'],
                'type' => $mc['type'],
                'name' => $mc['name'],
                'created_at' => $mc['created_at'],
                'updated_at' => $mc['updated_at'],
            ]);
        }



    }
}
