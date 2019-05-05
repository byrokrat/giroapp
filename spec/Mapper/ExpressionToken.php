<?php

declare(strict_types = 1);

namespace spec\byrokrat\giroapp\Mapper;

use Prophecy\Argument\Token\CallbackToken;
use hanneskod\yaysondb\Expression\ExpressionInterface;

class ExpressionToken extends CallbackToken
{
    /**
     * @var array
     */
    private $shouldMatch = [];

    /**
     * @var array
     */
    private $shouldNotMatch = [];

    public function __construct()
    {
        parent::__construct($this);
    }

    public function __invoke($expr)
    {
        if (!$expr instanceof ExpressionInterface) {
            throw new \InvalidArgumentException('Expected ExpressionInterface argument');
        }

        foreach ($this->shouldMatch as $operand) {
            if (!$expr->evaluate($operand)) {
                return false;
            }
        }

        foreach ($this->shouldNotMatch as $operand) {
            if ($expr->evaluate($operand)) {
                return false;
            }
        }

        return true;
    }

    public function shouldMatch($operand): self
    {
        $this->shouldMatch[] = $operand;
        return $this;
    }

    public function shouldNotMatch($operand): self
    {
        $this->shouldNotMatch[] = $operand;
        return $this;
    }
}
