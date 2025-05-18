<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Number to Khmer Converter</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1> Convert Number to Khmer Words KH</h1>
        <form method="POST">
            <input type="text" name="number" placeholder="Enter a number..." autocomplete="off">
            <button type="submit">Convert</button>
        </form>

        <?php
        function numberToKhmerWords($number)
        {
            $khmerNumbers = ['', 'មួយ', 'ពីរ', 'បី', 'បួន', 'ប្រាំ', 'ប្រាំមួយ', 'ប្រាំពីរ', 'ប្រាំបី', 'ប្រាំបួន'];
            $khmerTens = [
                10 => 'ដប់',
                20 => 'ម្ភៃ',
                30 => 'សាមសិប',
                40 => 'សែសិប',
                50 => 'ហាសិប',
                60 => 'ហុកសិប',
                70 => 'ចិតសិប',
                80 => 'ប៉ែតសិប',
                90 => 'កៅសិប'
            ];
            $khmerUnits = ['', 'ដប់', 'រយ', 'ពាន់', 'ម៉ឺន', 'សែន', 'លាន', 'ពាន់លាន', 'ទ្រីលាន'];

            if ($number == 0) {
                return 'សូន្យ';
            }

            $result = '';

            $unitPositions = [
                1000000 => 'លាន',
                100000  => 'សែន',
                10000   => 'ម៉ឺន',
                1000    => 'ពាន់',
                100     => 'រយ',
            ];

            foreach ($unitPositions as $value => $word) {
                if ($number >= $value) {
                    $unitValue = floor($number / $value);
                    $number %= $value;
                    if ($unitValue == 1 && $value >= 100000000000) {
                        $result .= $word . '';
                    } else {
                        $result .= numberToKhmerWords($unitValue) . '' . $word . '';
                    }
                }
            }

            if ($number >= 10) {
                if (isset($khmerTens[$number])) {
                    $result .= $khmerTens[$number] . '';
                } else {
                    $tens = floor($number / 10) * 10;
                    $ones = $number % 10;
                    $result .= $khmerTens[$tens] . '' . $khmerNumbers[$ones] . '';
                }
            } elseif ($number > 0) {
                $result .= $khmerNumbers[$number] . '';
            }

            return trim($result);
        }
        function ConvertKHRtoUSD($number)
        {
            $NewNumber = $number / 4000;
            $result = number_format($NewNumber, 2, '.', '');
            echo "<p>💵បំលែងជាលុយដុល្លារ​ : <strong>$result $</strong></p>";
            return $result;
        }
        function InputFileKHR($GetNumber, $number)
        {
            $filename = "TextFile.txt";
            $file = fopen($filename, "a");
            $finalResult = $number . "រៀល\tត្រូវនឹងលុយដុល្លារ " . $GetNumber . "ដុល្លារ\n";
            if ($file) {
                fwrite($file, $finalResult);
                fclose($file);
            }
        }
        function numberToEnglishWords($number)
        {
            $ENNumbers = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine'];
            $ENTeens = [
                11 => 'Eleven',
                12 => 'Twelve',
                13 => 'Thirteen',
                14 => 'Fourteen',
                15 => 'Fifteen',
                16 => 'Sixteen',
                17 => 'Seventeen',
                18 => 'Eighteen',
                19 => 'Nineteen'
            ];
            $ENTens = [
                10 => 'Ten',
                20 => 'Twenty',
                30 => 'Thirty',
                40 => 'Forty',
                50 => 'Fifty',
                60 => 'Sixty',
                70 => 'Seventy',
                80 => 'Eighty',
                90 => 'Ninety'
            ];
            $ENUnits = [
                1000000 => 'Million',
                1000    => 'Thousand',
                100     => 'Hundred'
            ];

            if ($number == 0) {
                return 'Zero';
            }

            $result = '';
            foreach ($ENUnits as $value => $word) {
                if ($number >= $value) {
                    $unitValue = floor($number / $value);
                    $number %= $value;

                    if ($unitValue == 1 && $value >= 10000000000000) {
                        $result .= $word . ' ';
                    } else {
                        $result .= numberToEnglishWords($unitValue) . ' ' . $word . ' ';
                    }
                }
            }
            if ($number >= 11 && $number <= 19) {
                $result .= $ENTeens[$number] . ' ';
                return trim($result);
            }
            if ($number >= 10) {
                if (isset($ENTens[$number])) {
                    $result .= $ENTens[$number] . ' ';
                } else {
                    $tens = floor($number / 10) * 10;
                    $ones = $number % 10;
                    $result .= $ENTens[$tens] . ' ' . $ENNumbers[$ones] . ' ';
                }
            } elseif ($number > 0) {
                $result .= $ENNumbers[$number] . ' ';
            }

            return trim($result);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $number = $_POST["number"];
            if (is_numeric($number)) {
                $convertedTextKH = numberToKhmerWords((int)$number);
                $convertedTextEN = numberToEnglishWords((int)$number);
                echo "<p><b style='color:red;'>English</b> : <strong>$number</strong> → <strong>$convertedTextEN Riel</strong></p>";
                echo "<p><b style='color:red;'>Khmer</b> : <strong>$number</strong> → <strong>$convertedTextKH រៀល</strong></p>";
                $GetNumber = ConvertKHRtoUSD($number);
                InputFileKHR($GetNumber, $number);
            } else {
                echo "<p style='color: red;'>❌ Please enter a valid number.</p>";
            }
        }
        ?>
    </div>
</body>

</html>