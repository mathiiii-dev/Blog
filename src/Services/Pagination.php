<?php

namespace App\Services;

use App\Repository\PostRepository;

class Pagination extends Twig
{

    public function getPostPagination($page): array
    {
        $postRepo = new PostRepository();
        $currentPage = (int)$page ?? 1;
        $perPage = 12;
        $count = $postRepo->countPosts();
        $pages = ceil((int)$count[0] / $perPage);
        $offset = $perPage * ($currentPage - 1);
        $overPage = false;

        if ($currentPage <= 0 || $currentPage > $pages || !filter_var($page, FILTER_VALIDATE_INT)) {
            $overPage = true;
        }

        return [
            'perPage' => $perPage,
            'offset' => $offset,
            'pages' => $pages,
            'currentPage' => $currentPage,
            'overPage' => $overPage
        ];
    }
}
