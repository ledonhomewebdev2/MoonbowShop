<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;

use App\ForumTopic;

class ManageTopicsController extends ManageController
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $user = $this->getLoggedinUser();

        return view('manage.topic.topic', [
            'topics' => $this->getTopicsPostedByUser($user->id),
            'deletedtopics' => ForumTopic::onlyTrashed()->get(),
            'deletedtopics' => ForumTopic::onlyTrashed()->get(),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $topic = ForumTopic::find($id);
        $topic->delete();

        return redirect()->route('topicmanager.index');
    }

    public function forcedelete($id)
    {
        $topic = ForumTopic::onlyTrashed()->find($id);
        $topic->forceDelete();

        return redirect()->route('topicmanager.index');
    }

    public function restore($id)
    {
        $topic = ForumTopic::onlyTrashed()->find($id);
        $topic->restore();

        return redirect()->route('topicmanager.index');
    }

    public function getCommentOnTopic($id) {

        $topic = ForumTopic::find($id);

        return $topic->comment;

        return view('forum.read', [
            'topics' => $topic,
        ]);
    }

    public function getTopic($id) {

        $topic = ForumTopic::find($id);

        return $topic;
    }

    public function getAllTopics() {

        $topic = ForumTopic::all();
        return $topic;
    }

    public function getTopicsPostedByUser($userid) {

        $topic = ForumTopic::where('topic_author_id', $userid)->get();
        return $topic;
    }

    public function getTopicTopFiveMostView()
    {
        $topic = ForumTopic::orderBy('topic_views', 'desc')->take(5)->get();
        return $topic;
    }
}
