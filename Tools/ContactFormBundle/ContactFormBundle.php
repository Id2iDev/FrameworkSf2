<?php

namespace Id2i\Tools\ContactFormBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContactFormBundle extends Bundle
{
    public function getParent(){
        return "MremiContactBundle";
    }
}
