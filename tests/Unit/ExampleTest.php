<?php

test('that true is true', function () {
    expect(true)->toBeTrue();
});


function add($n1, $n2){
    return $n1 + $n2;
}

test('2 + 2 is 4', function () {
    expect(add(2, 2))->toBe(4);
});
