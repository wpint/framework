<?php 
namespace WPINT\Framework\Console;

use Attribute;

#[Attribute()]
class SubCommandAttribute
{
    /**
     * construct
     *
     * @param string|null $description
     */
    public function __construct(public ?string $description){}
}