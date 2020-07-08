<?php declare(strict_types=1);

require_once('MatrixTraversal.php');

class MatrixTraversalTest
{
    /**
     * @return void
     */
    public static function testMatrixTraversal(): void
    {
        $matrix = [
            [3, 7, 1],
            [8, 5, 5],
            [7, 2, 9],
	];
	    
        var_dump(MatrixTraversal::getMaximunPathValue($matrix, [], 3, 3, 0, 0, 0));

        $matrix = [
            [3, 7, 1, 5],
            [8, 5, 5, 4],
            [7, 2, 9, 3],
            [4, 1, 7, 5],
        ];
	    
        var_dump(MatrixTraversal::getMaximunPathValue($matrix, [], 4, 4, 0, 0, 0));
    }
}

MatrixTraversalTest::testMatrixTraversal();
