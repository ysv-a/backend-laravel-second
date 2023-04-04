<?php

namespace App\GraphQL\Scalars;

use App\ValueObjects\Price;
use GraphQL\Language\AST\Node;
use App\ValueObjects\PriceReverse;
use GraphQL\Type\Definition\ScalarType;

/**
 * Read more about scalars here https://webonyx.github.io/graphql-php/type-definitions/scalars
 */
final class Money extends ScalarType
{
    /**
     * Serializes an internal value to include in a response.
     */
    public function serialize(mixed $value): mixed
    {
        return new Price($value->cent);
    }

    /**
     * Parses an externally provided value (query variable) to use as an input
     */
    public function parseValue(mixed $value): mixed
    {
        return new PriceReverse($value);
        // TODO implement validation and transformation of $value
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * Should throw an exception with a client friendly message on invalid value nodes, @see \GraphQL\Error\ClientAware.
     *
     * @param  \GraphQL\Language\AST\ValueNode&\GraphQL\Language\AST\Node  $valueNode
     * @param  array<string, mixed>|null  $variables
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null): mxied
    {
        dd($valueNode);
    }
}
