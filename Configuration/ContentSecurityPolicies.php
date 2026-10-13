<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Directive;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Mutation;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationCollection;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\MutationMode;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\Scope;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceKeyword;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\SourceScheme;
use TYPO3\CMS\Core\Security\ContentSecurityPolicy\UriValue;
use TYPO3\CMS\Core\Type\Map;

return Map::fromEntries(
    [
        // Provide declarations for the backend
        Scope::backend(),
        // NOTICE: When using `MutationMode::Set` existing declarations will be overridden

        new MutationCollection(
            /*
            // Results in `default-src 'self'`
            new Mutation(
                MutationMode::Set,
                Directive::DefaultSrc,
                SourceKeyword::self,
            ),

            // Extends the ancestor directive ('default-src'),
            // thus reuses 'self' and adds additional sources
            // Results in `img-src 'self' data: https://*.typo3.org`
            new Mutation(
                MutationMode::Extend,
                Directive::ImgSrc,
                SourceScheme::data,
                new UriValue('https://*.typo3.org'),
            ),
            // NOTICE: the following two instructions for `Directive::ImgSrc` are identical to the previous instruction,
            // `MutationMode::Extend` is a shortcut for `MutationMode::InheritOnce` and `MutationMode::Append`
            // new Mutation(MutationMode::InheritOnce, Directive::ImgSrc, SourceScheme::data),
            // new Mutation(MutationMode::Append, Directive::ImgSrc, SourceScheme::data, new UriValue('https://*.typo3.org')),

            // Extends the ancestor directive ('default-src'),
            // thus reuses 'self' and adds additional sources
            // Results in `script-src 'self' 'nonce-[random]'`
            // ('nonce-proxy' is substituted when compiling the policy)
            new Mutation(
                MutationMode::Extend,
                Directive::ScriptSrc,
                SourceKeyword::nonceProxy,
            ),

            // Sets (overrides) the directive,
            // thus ignores 'self' of the 'default-src' directive
            // Results in `worker-src blob:`
            new Mutation(
                MutationMode::Set,
                Directive::WorkerSrc,
                SourceScheme::blob,
            ),
        */),

    ],
    [
        // You can also additionally provide frontend declarations
        Scope::frontend(),
        new MutationCollection(
            new Mutation(
                MutationMode::Extend,
                Directive::ScriptSrcElem,
                new UriValue('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js'),
            ),

            new Mutation(
                MutationMode::Extend,
                Directive::ScriptSrcElem,
                new UriValue('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'),
            ),

            new Mutation(
                MutationMode::Extend,
                Directive::ScriptSrcElem,
                new UriValue('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js'),
            ),

            new Mutation(
                MutationMode::Extend,
                Directive::StyleSrcElem,
                new UriValue('https://cdn.datatables.net'),
            ),

            new Mutation(
                MutationMode::Extend,
                Directive::ScriptSrcElem,
                new UriValue('https://cdn.datatables.net'),
            ),
        ),
    ],
);
