<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class GreetService
{
    public function getNameFromRequest(Request $request): string
    {
        return $request->get('name') ?? '';
    }
}
