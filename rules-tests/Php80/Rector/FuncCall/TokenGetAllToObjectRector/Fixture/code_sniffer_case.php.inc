<?php

namespace Rector\Tests\Php80\Rector\FuncCall\TokenGetAllToObjectRector\Fixture;

final class CodeSnifferCase
{
    public function run()
    {
        $code = '<?php echo 1;';

        $stringTokens = token_get_all($code);
        foreach ($stringTokens as $token) {
            if (is_array($token) === true && $token[0] === T_VARIABLE) {
                $error = 'Variable "%s" not allowed in double quoted string; use concatenation instead';
                $data  = [$token[1]];
                return $data;
            }
        }
    }
}

?>
-----
<?php

namespace Rector\Tests\Php80\Rector\FuncCall\TokenGetAllToObjectRector\Fixture;

final class CodeSnifferCase
{
    public function run()
    {
        $code = '<?php echo 1;';

        $stringTokens = \PhpToken::tokenize($code);
        foreach ($stringTokens as $token) {
            if ($token->is(T_VARIABLE)) {
                $error = 'Variable "%s" not allowed in double quoted string; use concatenation instead';
                $data  = [$token->text];
                return $data;
            }
        }
    }
}

?>
