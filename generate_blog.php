<?php

// Entry point for the static site generator

echo 'Static blog generator initialized.';

// Include the Composer autoloader to be able to use Parsedown
require_once __DIR__ . '/vendor/autoload.php';

// Define the function to convert markdown to HTML
function markdownToHtml($markdownText) {
    // Use Parsedown for markdown parsing
    $parsedown = new Parsedown();
    return $parsedown->text($markdownText);
}

// Define function to apply a template to content
function applyTemplate($content, $templateFile) {
    // Replace placeholders in the template file with the content
    return str_replace('{{content}}', $content, file_get_contents($templateFile));
}

// Define function to generate the static site
function generateStaticSite($contentDirectory, $templateDirectory, $outputDirectory) {
    // Get all markdown files from content directory
    $markdownFiles = glob($contentDirectory . '/*.md');

    // Check and create output directory if not exists
    if (!file_exists($outputDirectory)) {
        mkdir($outputDirectory, 0777, true);
    }

    // Process each markdown file
    foreach ($markdownFiles as $markdownFile) {
        // Convert markdown to HTML
        $markdownContent = file_get_contents($markdownFile);
        $htmlContent = markdownToHtml($markdownContent);

        // Apply template
        $templateFile = $templateDirectory . '/default.php';
        if (file_exists($templateFile)) {
            $htmlContent = applyTemplate($htmlContent, $templateFile);
        } else {
            die('Template file not found: ' . $templateFile);
        }

        // Generate output file path
        $outputFilePath = $outputDirectory . '/' . basename($markdownFile, '.md') . '.html';

        // Write the HTML content to the output file
        file_put_contents($outputFilePath, $htmlContent);
    }
    echo 'Static site generation completed.';
}

// generateStaticSite('blog_content', 'templates', 'output');

?>