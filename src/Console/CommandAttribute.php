<?php 
namespace WPINT\Framework\Console;

use Attribute;

#[Attribute()]
class CommandAttribute
{
    public function __construct(
        public ?array $args,
    )
    {}
}