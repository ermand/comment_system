<?php namespace spec\App;

use App\Post;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommentSpec extends ObjectBehavior {

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Comment');
    }

    function it_stores_a_new_comment()
    {
        $post = new Post;
        $newPost = $post->create([
            'id'      => 1,
            'name'    => 'Ermand Durro',
            'email'   => 'email@gmail.com',
            'message' => 'My very first test Post'
        ]);

        $this->create([
            'id'      => 1,
            'post_id' => $newPost->getId(),
            'name'    => 'Ermand Durro',
            'email'   => 'ermand@gmail.com',
            'body'    => 'My very first test comment'
        ]);

        $this->hasError()->shouldBe(false);
        $this->count()->shouldReturn(1);
    }
}
