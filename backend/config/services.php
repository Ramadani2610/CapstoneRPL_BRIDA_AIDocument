<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | LLM
    |--------------------------------------------------------------------------
    | Endpoint for an OpenAI-style model server (9router / Ollama / LM Studio /
    | OpenAI). The key lives only in .env, never in code or the frontend.
    | With LLM_ENABLED=false the whole LLM stage is skipped.
    */

    'llm' => [
        'enabled' => env('LLM_ENABLED', false),
        'base_url' => env('LLM_BASE_URL', 'http://localhost:20128/v1'),
        'api_key' => env('LLM_API_KEY', ''),
        'model' => env('LLM_MODEL', 'Daily-use'),
    ],

    /*
    |--------------------------------------------------------------------------
    | OCR (optional — without the tools, files are marked "gagal" and continue)
    |--------------------------------------------------------------------------
    | pdftotext reads a PDF text layer; pdftoppm + tesseract handle scans.
    | OCR_TESSDATA points at the tesseract language folder (ind+eng).
    */

    'ocr' => [
        'pdftotext' => env('OCR_PDFTOTEXT', 'pdftotext'),
        'pdftoppm' => env('OCR_PDFTOPPM', 'pdftoppm'),
        'tesseract' => env('OCR_TESSERACT', 'tesseract'),
        'tessdata' => env('OCR_TESSDATA', ''),
        'bahasa' => env('OCR_BAHASA', 'ind+eng'),
        'dpi' => env('OCR_DPI', 200),
        'max_halaman' => env('OCR_MAX_HALAMAN', 12),
        'ambang_teks' => env('OCR_AMBANG_TEKS', 120),
    ],

];
