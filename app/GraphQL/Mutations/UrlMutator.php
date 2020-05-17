<?php

namespace App\GraphQL\Mutations;

use App\Url;
use Illuminate\Support\Str;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class UrlMutator
{
    /**
     * Return a value for the field.
     *
     * @param null $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param mixed[] $args The arguments that were passed into the field.
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context Arbitrary data that is shared between all fields of a single query.
     * @param \GraphQL\Type\Definition\ResolveInfo $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */
    public function __invoke($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
    }

    /**
     * Returns the newly created shortlink
     *
     * @param null $rootValue
     * @param mixed[] $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext $context
     * @return App\Url
     */
    public function create($rootValue, array $args, GraphQLContext $context): Url
    {
        $shortLink = isset($args["input"]["short"]) ? $this->generateShortlink($args["input"]["short"]) : $this->generateShortlink();
        $url = Url::create([
            "link" => $args["input"]["link"],
            "shortlink" => $shortLink
        ]);

        return $url;
    }

    /**
     * Generate a unique shortlink
     *
     * @param String $short
     * @return String
     */
    private function generateShortlink(string $short = null): string
    {
        $randomKey = Str::lower(Str::random(3));
        $appUrl = env('APP_URL');

        if (!$short) {
            $short = Str::lower(Str::random(6));
        }

        $url = Url::where('shortlink', 'regexp', "^" . env('APP_URL') . $short . "[0-9]?-[a-z0-9]{3}$")->orderBy('id',
            'desc')->first();
        if ($url) {
            preg_match("/" . preg_quote($appUrl, '/') . $short . "(.*?)-/", $url->shortlink, $match);
            $increment = $match[1] ? ++$match[1] : 1;
            return $appUrl . $short . $increment . '-' . $randomKey;
        }
        return $appUrl . $short . "-" . $randomKey;
    }
}
