<?php

namespace App\Service;

use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MarkdownHelper
{
    private MarkdownInterface $markdown;
    private AdapterInterface $cache;
    private LoggerInterface $logger;

    public function __construct(MarkdownInterface $markdown, AdapterInterface $cache, LoggerInterface $logger)
    {
        $this->markdown = $markdown;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    public function parse(string $source): string
    {
        $item = $this->cache->getItem('markdown_' . md5($source));

        if (stripos($source, 'ipsum') !== false) {
            $this->logger->info('They are talking about ipsum again!');
        }

        if (!$item->isHit()) {
            $item->set($this->markdown->transform($source));
            $this->cache->save($item);
        }

        return $item->get();
    }
}
