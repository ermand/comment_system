<?php namespace spec\App;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostSpec extends ObjectBehavior {
    
    function it_is_initializable()
    {
        $this->shouldHaveType('App\Post');
    }
    
    function it_stores_a_new_post()
    {
        $this->create([
            'id' => 1,
            'name' => 'Ermand Durro',
            'email' => 'email@gmail.com',
            'message' => 'My very first test Post'
        ]);

        $this->hasError()->shouldBe(FALSE);
        $this->count()->shouldReturn(1);
    }

    function it_should_return_error_for_invalid_message()
    {
        $this->create([
            'id' => 1,
            'name' => 'Ermand Durro',
            'email' => 'email@gmail.com',
            'message' => 'My post'
        ]);

        $this->hasError()->shouldBe(TRUE);
        $this->getErrors()->shouldReturn([ 0 => 'Message should have min: 10 characters.']);
    }
}
