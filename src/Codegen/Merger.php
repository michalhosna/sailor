<?php

declare(strict_types=1);

namespace Spawnia\Sailor\Codegen;

use GraphQL\Language\AST\DocumentNode;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\NodeList;

class Merger
{
    /**
     * @param  array<string, DocumentNode>  $documents
     */
    public static function combine(array $documents): DocumentNode
    {
        /** @var DocumentNode $root */
        $root = array_pop($documents);

        $root->definitions = array_reduce(
            $documents,
            static function (NodeList $definitions, DocumentNode $document): NodeList {
                /** @var NodeList<Node> $nodeList */
                $nodeList = $document->definitions;

                return $definitions->merge($nodeList);
            },
            $root->definitions
        );

        return $root;
    }
}
