<?php

use App\Models\Posts\Post;
use App\Policies\PostPolicy;

class PostPolicyTest extends BrowserKitTest
{
    /**
     * @group policies
     */
    public function test_view()
    {
        (new PostPolicy)->view($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_create()
    {
        (new PostPolicy)->create($this->authUser());
    }

    /**
     * @group policies
     */
    public function test_update()
    {
        $post = factory(Post::class)->create();

        (new PostPolicy)->update($this->authUser(), $post);
    }

    /**
     * @group policies
     */
    public function test_delete()
    {
        $post = factory(Post::class)->create();

        (new PostPolicy)->delete($this->authUser(), $post);
    }
}
