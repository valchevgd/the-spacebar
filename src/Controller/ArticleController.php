<?php

namespace App\Controller;

use App\Service\MarkdownHelper;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route(path="/", name="app_homepage", methods={"GET"})
     * @return Response
     */
    public function homepage(): Response
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route(path="/news/{slug}", name="article_show", methods={"GET"})
     * @param string $slug
     * @return Response
     */
    public function show(string $slug, MarkdownHelper $markdownHelper): Response
    {
        $articleContent = <<<EOF
**Lorem ipsum** dolor sit amet, consectetur adipiscing elit. Vestibulum aliquam lacus nunc. Sed finibus ipsum purus, id sollicitudin urna placerat in. Morbi posuere, eros sit amet viverra dictum, urna mi cursus lorem, id laoreet tortor est ut ante. Proin gravida, massa ac sollicitudin dignissim, ipsum ex volutpat felis, vitae accumsan mi tortor vitae ipsum. Phasellus ornare tristique tellus, id rhoncus ipsum elementum id. Aenean id tellus vel ex eleifend sagittis eget in erat. Integer vestibulum ante a dolor aliquam sollicitudin. Curabitur tincidunt, justo vitae egestas gravida, elit tellus semper mi, vel elementum velit elit at arcu.

Quisque blandit egestas libero, in iaculis nunc tincidunt ut. Aliquam congue tellus ligula, at pulvinar magna eleifend et. Phasellus vitae iaculis leo, vel vulputate tellus. Praesent luctus dolor vestibulum faucibus ullamcorper. Duis rutrum est nec dolor convallis, sit amet luctus enim fringilla. Maecenas tortor enim, blandit ultrices maximus nec, tempor sit amet velit. Phasellus id erat laoreet augue volutpat dictum et eu nibh. Etiam accumsan non arcu at dignissim. Vivamus gravida, nulla sit amet faucibus laoreet, lorem nunc dictum est, at porttitor velit turpis non arcu. Donec molestie felis quis lectus pretium blandit. Integer placerat ante et risus malesuada tristique. Nunc quam sem, malesuada quis dui ac, pellentesque consequat augue.

Aliquam turpis elit, pretium in commodo quis, condimentum id urna. Aliquam id laoreet ligula, et varius tellus. Pellentesque molestie lobortis eros, quis varius enim congue eget. Nulla augue nisl, auctor at imperdiet eget, aliquam eu sem. Curabitur malesuada purus id lectus rhoncus viverra. Sed tempus, nibh et pulvinar pretium, arcu ligula mollis turpis, sed imperdiet diam justo nec orci. Suspendisse potenti. Integer ullamcorper lacus a placerat convallis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc condimentum ante id augue iaculis, non tempus sem feugiat. Nam posuere, lectus id egestas vehicula, purus eros aliquam libero, at facilisis diam tortor nec metus. Vivamus et vehicula enim, id interdum dui. Suspendisse porta et purus sed luctus. Sed sodales mauris quis lectus feugiat posuere. Nulla vitae varius metus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;
EOF;

        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'articleContent' => $markdownHelper->parse($articleContent),
            'comments' => [
                'first comment',
                'second comment',
                'third comment'
            ]
        ]);
    }

    /**
     * @Route(path="/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart(string $slug, LoggerInterface $logger): Response
    {
        $logger->info('Article has being hearted');

        return $this->json(['heart' => rand(5, 100)]);
    }
}
