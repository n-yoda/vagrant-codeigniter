<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TimeLine extends CI_Controller
{
    // はじめに読み込むツイート数
    const DEFAULT_TWEET_COUNT = 10;
    // ツイート取得の最大数。
    const LOAD_TWEET_COUNT_MAX = 10;

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html', 'my_javascript'));
        $this->load->library('table', 'table');
        $this->load->model('TweetModel', 'tweetModel');
        $this->load->model('UserModel', 'userModel');
    }

    public function index()
    {
        // ログイン情報
        $user =$this->userModel->getLoggedInUser();

        //ツイートを取得
        $tweets = $this->tweetModel->getTweets(self::DEFAULT_TWEET_COUNT)->result();

        // 先頭にプロトタイプ用のデータを付け加える
        $prototype = new TweetModel();
        $prototype->tweet_id = 'prototype';
        array_unshift($tweets, $prototype);

        $data = array('tweets' => $tweets, 'user' => $user);
        $this->load->view('timeline_view', $data);
    }


    // ツイートをして結果のメッセージを返す
    public function tweet()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('text', 'ツイート内容', 'required');

        if ($this->form_validation->run() == false) {
            $this->output->set_status_header('400', $this->form_validation->error_string());
        } else if (!$this->session->userdata('user_id')) {
            $this->output->set_status_header('401', 'ログインしてください。');
        } else {
            $text = $this->input->post('text');
            $userId = $this->session->userdata('user_id');
            $this->tweetModel->addTweet($userId, $text);
            $this->output->set_output("ツイートを投稿しました。");
        }
    }

    // 指定したtweet_idより新しいツイートを取得
    public function newer_tweets()
    {
        $id = $this->input->post('id');
        $count = $this->getCount();
        $tweets = array();
        if(!empty($id))
            $tweets = $this->tweetModel->getNewerTweets($id, $count)->result_array();
        $this->outputArrayToJson($tweets);
    }

    // 指定したtweet_idより古いツイートを取得
    public function older_tweets()
    {
        // インディケーター回したいのでわざと遅延ｗｗ
        sleep(2);

        $id = $this->input->post('id');
        $count = $this->getCount();
        $tweets = array();
        if(!empty($id))
            $tweets = $this->tweetModel->getOlderTweets($id, $count)->result_array();
        $this->outputArrayToJson($tweets);
    }

    private function getCount()
    {
        $count = $this->input->post('count');
        if ($count == null || $count > self::LOAD_TWEET_COUNT_MAX)
        {
            return self::LOAD_TWEET_COUNT_MAX;
        }
        return $count;
    }


    // tweet取得の共通部分
    private function outputArrayToJson($array)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($array));
    }

}
