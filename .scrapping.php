<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Book Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h1>Search for a Book</h1>
    <form action="" method="GET">
        <input type="text" name="query" placeholder="Enter book title" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

// Function to search DOAB for books
function searchDOAB($query) {
    $client = new Client();
    $url = "https://www.doabooks.org/doab?uiLanguage=en&query=" . urlencode($query);

    try {
        // Send a GET request to DOAB
        $response = $client->request('GET', $url);

        // Parse the HTML response
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);

        // Extract book metadata
        $books = [];
        $crawler->filter('div.record')->each(function (Crawler $node) use (&$books) {
            $title = $node->filter('h3.title')->text();
            $author = $node->filter('div.author')->text();
            $publisher = $node->filter('div.publisher')->text();
            $link = $node->filter('a.external-link')->attr('href');

            $books[] = [
                'title' => $title,
                'author' => $author,
                'publisher' => $publisher,
                'link' => $link,
            ];
        });

        return $books;
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}

// Function to serve a PDF file
function servePDF($url) {
    // Validate the URL
    if (filter_var($url, FILTER_VALIDATE_URL) === false) {
        die("Invalid URL.");
    }

    // Ensure the URL points to a PDF file
    if (pathinfo($url, PATHINFO_EXTENSION) !== 'pdf') {
        die("Invalid file type. Only PDF files are allowed.");
    }

    // Fetch the file content
    $fileContent = file_get_contents($url);

    if ($fileContent === false) {
        die("Failed to fetch the file.");
    }

    // Set headers to force download the file
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($url) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($fileContent));

    // Output the file content
    echo $fileContent;
    exit;
}

// Handle user input
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $books = searchDOAB($query);

    if (is_array($books)) {
        echo "<h1>Search Results for '$query'</h1>";
        foreach ($books as $book) {
            echo "<p><strong>Title:</strong> " . $book['title'] . "<br>";
            echo "<strong>Author:</strong> " . $book['author'] . "<br>";
            echo "<strong>Publisher:</strong> " . $book['publisher'] . "<br>";
            echo "<a href='?url=" . urlencode($book['link']) . "'>Download</a></p>";
        }
    } else {
        echo $books; // Display error message
    }
} elseif (isset($_GET['url'])) {
    // Serve the PDF file
    servePDF($_GET['url']);
}
?>