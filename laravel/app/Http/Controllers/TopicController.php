<?php

namespace App\Http\Controllers;


use DB;
use Session;
use Storage;
use Validator;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GrahamCampbell\Flysystem\Facades\Flysystem;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(\App\Models\Topic $topic)
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
            'topic.scope' => 'required',
            'topic.sort_order' => 'required',
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



        /*
         *
         * $DELMSG='';
         *

        foreach($fileFormats['newsletter_file_types_descriptions'] as $k => $v)
        {
            $fileType = strtolower($k)."_file";

            if (isset($_FILES['newsletter']['tmp_name'][$fileType]))
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
            }

            if ( isset( $request['newsletter']['delete_file'][$k]) )
            {
            // delete files and rows when checkbox has been checked
                Storage::delete('/'. env('NEWSLETTERS_FILES_DIR') .'/'. $request['newsletter'][$k]);
                NewslettersData::destroy($request['newsletter']['delete_file'][$k]);
                $DELMSG .= ' deleted '. $request['newsletter'][$k];
            }
        }
         * */

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

        //edit version of form for initial loading
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
        //dd($topic);
     //   dd($request->all());

        // turn title into slug
        $rules = [
            'topic.name' => 'required|unique:topics,name|max:255',
            'topic.scope' => 'required',
            'topic.sort_order' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('topic_edit'))
                ->withErrors($validator)
                ->withInput();
        }
        $topic->fill($request->input('topic'));
        //$topic->fill($request['topic']);
        $topic->save();


        /*
 *
 * $DELMSG='';
 *
foreach($fileFormats['newsletter_file_types_descriptions'] as $k => $v)
{
    $fileType = strtolower($k)."_file";
    if (isset($_FILES['newsletter']['tmp_name'][$fileType]))
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
    }
    if ( isset( $request['newsletter']['delete_file'][$k]) )
    {
    // delete files and rows when checkbox has been checked
        Storage::delete('/'. env('NEWSLETTERS_FILES_DIR') .'/'. $request['newsletter'][$k]);
        NewslettersData::destroy($request['newsletter']['delete_file'][$k]);
        $DELMSG .= ' deleted '. $request['newsletter'][$k];
    }
}

 * */
       //

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

            Session::flash('success', str_plural('Topic', count($request['id'])) . ' deleted.');
        }
        else
        {
            Session::flash('success', 'No topics were deleted.');
        }

        return redirect()->route('topics_list');

    }
}
