<?php

namespace App\PHPClass;

use App\Repository\PostRepository;

class Pagination extends Twig
{

    public function getPostPagination($page)
    {
        $postRepo = new PostRepository();
        $currentPage = (int)$page ?? 1;
        $perPage = 12;
        $count = $postRepo->countPosts();
        $pages = ceil((int)$count[0] / $perPage);
        $offset = $perPage * ($currentPage - 1);

        if($currentPage <= 0 || $currentPage > $pages || !filter_var($page, FILTER_VALIDATE_INT))
        {
            http_response_code(404);
            return $this->twig('404.html.twig');
        }
        return [
            'perPage' => $perPage,
            'offset' => $offset,
            'pages' => $pages,
            'currentPage' => $currentPage
        ];
    }
}
