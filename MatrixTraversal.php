<?php declare(strict_types=1);

class MatrixTraversal
{
    /**
     * @param array    $matrix
     * @param array    $path
     * @param int      $m
     * @param int      $n
     * @param int      $i
     * @param int      $j
     * @param int      $index
     * @param int|null $maximum
     *
     * @return int|null
     */
    public static function getMaximunPathValue(
        array $matrix,
        array $path,
        int $m,
        int $n,
        int $i,
        int $j,
        int $index,
        int &$maximum = null
    ): ?int {
        $path[$index] = $matrix[$i][$j];

        if ($i === $m - 1) {
            for ($k = $j + 1; $k < $n; $k++) {
                $path[$index + $k - $j] = $matrix[$i][$k];
            }
            $maximum = self::caculateMaximumValue($path, $maximum);
            return null;
        }

        if ($j === $n - 1) {
            for ($k = $i + 1; $k < $m; $k++) {
                $path[$index + $k - $i] = $matrix[$k][$j];
            }
            $maximum = self::caculateMaximumValue($path, $maximum);
            return null;
        }

        self::getMaximunPathValue($matrix, $path, $m, $n, $i + 1, $j, $index + 1, $maximum);
        self::getMaximunPathValue($matrix, $path,  $m, $n, $i, $j + 1, $index + 1, $maximum);

        return $maximum;
    }

    /**
     * @param array $path
     * @param int|null   $maximum
     *
     * @return int
     */
    private static function caculateMaximumValue(array $path, int $maximum = null): int
    {
        $sum = array_sum($path);

        if ($maximum < $sum) {
            $maximum = $sum;
        }

        return $maximum;
    }
}
