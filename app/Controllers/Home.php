<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('index');
    }

    public function getPosts(): string
    {
		$db = db_connect();
		$query = $db->query('select * from posts');
		$data['posts'] = $query->getResultArray();
        echo "<pre>"; print_r($data);exit;
        return view('demo', $data);
    }

    public function show($id=null) {
        $db = db_connect();
		$query = $db->query('select * from posts where pid = ?', [(int)$id]);
		$data = $query->getResultArray();
        echo "Executed Query: " . $db->getLastQuery();
        echo "<pre>"; print_r($data);exit;
    }
}
