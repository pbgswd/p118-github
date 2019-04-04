<?php

namespace App\Http\Controllers;


use DB;
use Session;
use Storage;
use Validator;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use GrahamCampbell\Flysystem\Facades\Flysystem;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = [];

        //$topics = Topic::orderBy('sort_order', 'ASC')->paginate(20);

        $topics = Topic::sortable()->paginate(60);
        return view('admin.listtopics', ['data'=>array('topics'=>$topics )]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topic = new \App\Models\Topic;

        return view('admin.topic', ['data'=>['topic'=>$topic, 'action'=>'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.access_level' => 'required|string',
            'topic.sort_order' =>  'required|numeric',
            'topic.in_menu' => 'boolean',
            'topic.allow_comments' => 'boolean',
            'topic.live' => 'boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect(route('topic_create'))
                ->withErrors($validator)
                ->withInput();
        }

        $topic = new Topic($request->input('topic'));

        $topic->save();

        $fileType = strtolower($k)."_file";

      /*  if (isset($_FILES['newsletter']['tmp_name'][$fileType]))
        {
            $newslettersData = new \App\Models\NewslettersData;

            $newslettersData->fill(['file_name' => $_FILES['newsletter']['name'][$fileType],
                                    'file_type' => $_FILES['newsletter']['type'][$fileType],
                                    'newsletter_format_code' => $k]);

            if ( !empty($_FILES['newsletter']['tmp_name'][$fileType]) )
            {
                $stream = fopen($_FILES['newsletter']['tmp_name'][$fileType], 'r+');
                Flysystem::connection('newsletters')->put($_FILES['newsletter']['name'][$fileType], $stream);
                fclose($stream);

                if(Storage::exists('/' . env('NEWSLETTERS_FILES_DIR') . '/' . $_FILES['newsletter']['name'][$fileType]))
                {
                    $newsletter->newslettersData()->save($newslettersData);
                     $DELMSG .= ' Saved ' . $_FILES['newsletter']['name'][$fileType];
                }
                else
                {
                    flash()->warning($_FILES['newsletter']['name'][$fileType] . ' was not saved. ' );
                }
            }
        }*/

        Session::flash('success', "You have saved a new topic");
        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Models\Topic $topic)
    {
        $data = ['topic'=>$topic, 'action'=>'Edit'];
        return view('admin.topic', ['data'=> $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)

    {
        $validator = Validator::make($request->all(), [
            'topics.name' => [
                Rule::unique('topics')->ignore($topic),
                'required|string|max:255',
            ],
            'topic.access_level' => 'required|string|max:255',
            'topic.sort_order' =>  'required|numeric',
            'topic.in_menu' => 'boolean',
            'topic.allow_comments' => 'boolean',
            'topic.live' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect(route('topic_edit', $topic->slug))
                ->withErrors($validator)
                ->withInput();
        }

        /*
         * if ( !empty($_SERVER['CONTENT_LENGTH']) && empty($_FILES) && empty($_POST) )
            echo 'The uploaded zip was too large. You must upload a file smaller than ' . ini_get("upload_max_filesize");
        */


        $DELMSG='';

        // image vs file name of image. what to do here

      if ( isset( $request->image ) )
        {
            if ( $request->image )
            {
//dd($_FILES['topic']['name']['image']);

               // $path = Storage::putFile('public', $request->topic['image']);

/*                $path = Storage::putFileAs(
                    'public',
                    $request->topic['image'],
                    $_FILES['topic']['name']['image']
                );*/

             //   $path = $request->file($request->topic['image'])->store();
//file_put_contents
               //Storage::disk('public')->put($request->topic['image'], 'Contents'); // works
              //  Storagdisk('local')->put($request->topic['image'], 'Contents'); // works
/*
                $stream = fopen($_FILES['newsletter']['tmp_name']['image'], 'r+');
                Flysystem::connection('topic')->put($_FILES['topic']['image'], $stream);
                fclose($stream);

                if(Storage::exists('/' . env('FILES_DIR') . '/' . $_FILES['topics']['image']))
                {
                    $topic->save();
                     $DELMSG .= ' Saved ' . $_FILES['newsletter']['name']['image'];
                }
                else
                {
                    flash()->warning($_FILES['newsletter']['name']['image'] . ' was not saved. ' );
                }
*/


                $data = $request['topic'];

//dump($request->file('image'));

                $data['image'] = $request->file('image')->storeAs('', $request->file('image')->getClientOriginalName());
//dd($data);



                /*
                 * $data = $request['topic'];
$data['image'] = $request->file('image')->getClientName();
$request->file('file_field_name')->storeAs('new_path', 'new_name');
$topic->fill($data);
                 * */





                $topic->fill($data);

               // $topic->fill($request['topic']);
                $topic->save();




            }
        }
        if ( isset( $request['topic']['delete_image']) )
        {
        // delete files and rows when checkbox has been checked

            Storage::disk('public')->delete( $request->topic['image'] );

            Session::flash('info', "You have deleted the image");
        }

        Session::flash('success', "You have edited the topic");

        return redirect()->route('topic_edit', [$topic->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Topic $topic)
    {

        // what to do with content under said topic?

        if(isset($request['id']))
        {

            /*
             *         $data = [];
        $data['newsletter_data'] = NewslettersData::where('newsletter_id', $request->id)->get();
        foreach($data['newsletter_data'] as $d)
        {
            Storage::delete('/'. env('NEWSLETTERS_FILES_DIR') .'/'. $d->file_name); // delete files
            NewslettersData::destroy($d['id']); // delete newsletter_data rows associated with newsletter
        }

             * */

            Topic::destroy($request['id']);

            Session::flash('success', Str::plural('Topic', count($request['id'])) . ' deleted.');
        }
        else
        {
            Session::flash('success', 'No topics were deleted.');
        }

        return redirect()->route('topics_list');

    }
}
