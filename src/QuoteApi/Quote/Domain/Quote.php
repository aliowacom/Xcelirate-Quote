<?php

declare(strict_types=1);

namespace XcelirateQuote\QuoteApi\Quote\Domain;

final class Quote
{
    public function __construct(
        private QuoteAuthor $author,
        private QuoteText $text,
    ){}

    public static function create(QuoteAuthor $author, QuoteText $text): self
    {
        $quote = new self($author, $text);

        return $quote;
    }

    public function author(): QuoteAuthor
    {
        return $this->author;
    }

    public function text(): QuoteText
    {
        return $this->text;
    }
}
