<?php

/*
 * This software is copyright to Hinson Stephens of Just Biz, Inc.
 * Please contact hinsonjr@justbiz.biz for information about the software.
 */

namespace App\Controller;

/**
 * Description of Admin
 *
 * @author hinso
 */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Admin {

    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'number' => $number,
        ]);
    }
	
}
