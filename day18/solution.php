<?php

class Pair
{
    protected $left = null;
    protected $right = null;
    protected $parent = null;

    public function setLeft($left)
    {
        $this->left = $left;
    }

    public function setRight($right)
    {
        $this->right = $right;
    }

    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    public function getParent(): ?Pair
    {
        return $this->parent;
    }

    public function getNestLevel()
    {
        if (!$this->parent) {
            return 0;
        }

        return $this->parent->getNestLevel() + 1;
    }

    public function getLeft()
    {
        return $this->left;
    }

    public function getRight()
    {
        return $this->right;
    }

    public function getMagnitude()
    {
        $result = 0;
        if (is_numeric($this->getLeft())) {
            $result += $this->getLeft() * 3;
        } else {
            $result += $this->getLeft()->getMagnitude() * 3;
        }

        if (is_numeric($this->getRight())) {
            $result += $this->getRight() * 2;
        } else {
            $result += $this->getRight()->getMagnitude() * 2;
        }

        return $result;
    }

    public function print()
    {
        return sprintf(
            '[%s,%s]',
            is_numeric($this->getLeft()) ? $this->getLeft() : $this->getLeft()->print(),
            is_numeric($this->getRight()) ? $this->getRight() : $this->getRight()->print()
        );
    }
}

function readArray($array) {
    $pair = new Pair();

    if (is_array($array[0])) {
        $left = readArray($array[0]);
        $left->setParent($pair);
    } else {
        $left = $array[0];
    }

    if (is_array($array[1])) {
        $right = readArray($array[1]);
        $right->setParent($pair);
    } else {
        $right = $array[1];
    }

    $pair->setLeft($left);
    $pair->setRight($right);

    return $pair;
}

function makeExposion(Pair $pair) {
    if ($pair->getNestLevel() == 4) {
        addLeft($pair, $pair->getLeft());
        addRight($pair, $pair->getRight());
        $parent = $pair->getParent();
        if ($parent->getLeft() instanceof Pair && $parent->getLeft() === $pair) {
            $parent->setLeft(0);
        } else {
            $parent->setRight(0);
        }
        return true;
    }

    $result = false;

    if ($pair->getLeft() instanceof Pair) {
        $result = makeExposion($pair->getLeft());
        if ($result) {
            return $result;
        }
    }

    if ($pair->getRight() instanceof Pair) {
        $result = makeExposion($pair->getRight());
    }

    return $result;
}

function makeSplit(Pair $pair): bool
{
    if (is_numeric($pair->getLeft())) {
        if ($pair->getLeft() >= 10) {
            $newPair = new Pair();
            $newPair->setLeft(round(floor($pair->getLeft() / 2)));
            $newPair->setRight(round(ceil($pair->getLeft() / 2)));
            $newPair->setParent($pair);
            $pair->setLeft($newPair);
            return true;
        }
    } else {
        $result = makeSplit($pair->getLeft());
        if ($result) {
            return $result;
        }
    }

    if (is_numeric($pair->getRight())) {
        if ($pair->getRight() >= 10) {
            $newPair = new Pair();
            $newPair->setLeft(round(floor($pair->getRight() / 2)));
            $newPair->setRight(round(ceil($pair->getRight() / 2)));
            $newPair->setParent($pair);
            $pair->setRight($newPair);
            return true;
        } else {
            return false;
        }

    } else {
        $result = makeSplit($pair->getRight());
    }

    return $result;
}

function addLeft(Pair $pair, $value): bool
{
    while (true) {
        $parent = $pair->getParent();
        if (is_null($parent)) {
            return false;
        }

        if (is_numeric($parent->getLeft())) {
            $parent->setLeft($parent->getLeft() + $value);
            return true;
        }

        if (is_int($parent->getLeft())) {
            $x = 1;
        }

        if (is_int($pair)) {
            $x = 1;
        }

        if ($parent->getLeft() !== $pair) {
            $pair = $parent->getLeft();
            break;
        }
        $pair = $parent;
    }

    while (true) {
        if (is_numeric($pair->getRight())) {
            $pair->setRight($pair->getRight() + $value);
            return true;
        } else {
            $pair = $pair->getRight();
        }
    }
}

function addRight(Pair $pair, $value): bool
{
    while (true) {
        $parent = $pair->getParent();
        if (is_null($parent)) {
            return false;
        }

        if (is_numeric($parent->getRight())) {
            $parent->setRight($parent->getRight() + $value);
            return true;
        }

        if (is_int($parent->getRight())) {
            $x = 1;
        }

        if (is_int($pair)) {
            $x = 1;
        }

        if ($parent->getRight() !== $pair) {
            $pair = $parent->getRight();
            $x = 1;
            break;
        }
        $x = 1;
        $pair = $parent;
    }

    while (true) {
        if (is_numeric($pair->getLeft())) {
            $pair->setLeft($pair->getLeft() + $value);
            return true;
        } else {
            $pair = $pair->getLeft();
        }
    }
}

$file = file('input.txt');
$pairs = [];
foreach ($file as $pair) {
    $pairs[] = readArray(json_decode(trim($pair)));
}

$result = null;
for ($i = 1, $c = count($pairs); $i < $c; $i++) {
    if ($i == 1) {
        $result = new Pair();
        $result->setLeft($pairs[0]);
        $pairs[0]->setParent($result);
        $result->setRight($pairs[$i]);
        $pairs[$i]->setParent($result);
    } else {
        $old = $result;
        $result = new Pair();
        $result->setLeft($old);
        $result->setRight($pairs[$i]);
        $old->setParent($result);
        $pairs[$i]->setParent($result);
    }

    echo $result->print() . ' after sum' . PHP_EOL;

    while (true) {
        if (makeExposion($result)) {
            echo $result->print() . ' explode' . PHP_EOL;
            continue;
        }
        if (!makeSplit($result)) {
            break;
        } else {
            echo $result->print() . ' split' . PHP_EOL;
        }
    }
}

echo $result->getMagnitude() . PHP_EOL;