<?php

namespace UnixDevil\Crawler\Contracts;

interface HtmlClientContract
{
    public function extract(): void;
}
