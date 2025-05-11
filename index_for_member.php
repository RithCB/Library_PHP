<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Handa Library</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="img/UC.png">

</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="https://uc.edu.kh/images/uc.png" alt="Logo" style="width: 60px;"> <!-- Replace with your logo URL -->
          </a>
      <a class="navbar-brand" href="#">Handa Library</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          <!-- </li>
          <li class="nav-item">
            <a class="nav-link" href="Login.php">Log in</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="SignUP.php">Sign up</a>
          </li>
           -->
        </ul>
        <form class="d-flex" role="search" action="index_for_member.php" method="post">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
          <button class="btn btn-outline-warning" type="submit" name="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  
  <script>
    document.addEventListener("click", function (event) {
      let navbar = document.querySelector(".navbar-collapse");
      let toggle = document.querySelector(".navbar-toggler");
  
      if (navbar.classList.contains("show") && !navbar.contains(event.target) && !toggle.contains(event.target)) {
        navbar.style.overflow = "hidden"; // Prevent sudden collapse
        setTimeout(() => {
          let bsCollapse = new bootstrap.Collapse(navbar, { toggle: false });
          bsCollapse.hide();
        }, 10); // Delay closing to allow the animation
      }
    });
  </script>
  
  

  <!-- Bootstrap JS (required for dropdown and toggler functionality) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
include("Database.php"); 
?>
  <?php
// API URL

//I write it my own no chatgpt
if(isset($_POST['submit'])){
    if(!empty($_POST['search'])){
        $search = trim($_POST['search']);
        $search = urlencode($search); 
        $apiUrl = "https://openlibrary.org/search.json?q={$search}"; 
        $response = file_get_contents($apiUrl);
        $bookKey = $book['cover_edition_key'] ?? ($book['edition_key'][0] ?? 'N/A');


// Decode JSON response
        $data = json_decode($response, true);

        // Check if books are found
        $books = array_slice($data['docs'] ?? [],0,20);
            }
}
else{
        $apiUrl = "https://openlibrary.org/search.json?q=william+shakespeare"; // Default API URL

        $response = file_get_contents($apiUrl);

        // Decode JSON response
        $data = json_decode($response, true);
        
        // Check if books are found
        $books = array_slice($data['docs'] ?? [],0,20);
}
// Fetch data from Open Library API



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book List with Preview</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .book { display: flex; align-items: center; border-bottom: 1px solid #ddd; padding: 10px; cursor: pointer; transition: background 0.3s; }
        .book:hover { background: #f1f1f1; }
        .book img { width: 80px; height: 120px; margin-right: 15px; object-fit: cover; }
        .book-details { flex: 1; }
        .book-title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .book-author, .book-year { color: #555; }

        /* Modal styles */
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 20px; border-radius: 8px; width: 80%; max-width: 500px; text-align: center; position: relative; }
        .modal img { max-width: 150px; height: auto; margin-bottom: 10px; }
        .close-btn { position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Book List</h2>
        
        <?php if (count($books) > 0): ?>
            <?php foreach ($books as $book): ?>
                <?php 
                    // Get cover ID
                    $coverId = $book['cover_i'] ?? null;
                    $coverUrl = $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}.jpg" : "https://via.placeholder.com/80x120?text=No+Image";

                    // Get book details
                    $title = $book['title'] ?? 'Unknown Title';
                    $author = $book['author_name'][0] ?? 'Unknown Author';
                    $year = $book['first_publish_year'] ?? 'Unknown Year';
                    // $bookKey = $book['cover_edition_key'] ?? ($book['edition_key'][0] ?? 'N/A');
                    // $actual_title = $title; 
                    // echo "actual title: ".$actual_title;
                    
                    $previewUrl = isset($book["key"]) ? "https://openlibrary.org/{$book['key']}/?edition={$book['edition_key'][0]}" : "https://openlibrary.org/{$book['edition_key'][0]}//{$year}";
                    // if (isset($book['key']) && isset($book['edition_key'][0])) {
                    //     $workUrl = "https://openlibrary.org/{$book['key']}/" . urlencode($title);
                    //     $editionUrl = "https://openlibrary.org/{$book['key']}/" . urlencode($title) . "?edition=key%3A/books/{$book['edition_key'][0]}";
                    // } else {
                    //     $editionUrl = "#"; // Fallback if no key or edition_key is available
                    // }


                        
                    
                    // $previewUrl = isset($book["key"]) ? "https://openlibrary.org/{$book['key']}/{$title}/edition={$book['docs']['key']}" : "https://openlibrary.org/{$book['edition_key'][0]}//{$year}";
                    // ?q=the+lord+of+the+rings
                    //https://openlibrary.org/works/OL17930368W/Atomic_Habits?edition=key%3A/books/OL36939272M
                ?>
                
                <div class="book" onclick="showPreview('<?= htmlspecialchars($title)?>', '<?= htmlspecialchars($author) ?>', '<?= htmlspecialchars($year) ?>', '<?= $coverUrl ?>', '<?= $previewUrl ?>')">
                <img src="<?= $coverUrl ?>" alt="<?= htmlspecialchars($title) ?>">
                <div class="book-details">
                    <div class="book-title"><?= htmlspecialchars($title) ?></div>
                    <div class="book-author">By: <?= htmlspecialchars($author) ?></div>
                    <div class="book-year">Published: <?= htmlspecialchars($year) ?></div>
                </div>
</div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <div class="modal" id="previewModal">
        <div class="modal-content">
            <span class="close-btn" onclick="closePreview()">&times;</span>
            <img id="modalCover" src="" alt="Book Cover">
            <h3 id="modalTitle"></h3>
            <p><strong>Author:</strong> <span id="modalAuthor"></span></p>
            <p><strong>Year:</strong> <span id="modalYear"></span></p>
            <a id="modalLink" href="#" target="_blank"><button>View on Open Library</button></a>
            <a id="modalLink2" onclick="borrow()" target="_blank"><button>Borrow</button></a>
        </div>
    </div>

    <nav aria-label="Page navigation example" >
  <ul class="pagination justify-content-center" >
    <li class="page-item "><a class="page-link pagination-color-warning" href="#">Previous</a></li>
    <li class="page-item"><a class="page-link pagination-color-warning" href="#">1</a></li>
    <li class="page-item"><a class="page-link pagination-color-warning" href="#">2</a></li>
    <li class="page-item"><a class="page-link pagination-color-warning" href="#">3</a></li>
    <li class="page-item"><a class="page-link pagination-color-warning" href="#">Next</a></li>
  </ul>
  </nav>


    <script>
            function showPreview(title, author, year, coverUrl, previewUrl) {
            // Set modal content
            document.getElementById("modalTitle").innerText = title;
            document.getElementById("modalAuthor").innerText = author;
            document.getElementById("modalYear").innerText = year;
            document.getElementById("modalCover").src = coverUrl;
            
            // Fix link issue
            document.getElementById("modalLink").href = previewUrl;

            // Show the modal
            document.getElementById("previewModal").style.display = "flex";
        }
        function borrow(){
            alert("We will send the pdf file via your email soon. Thank you."); 
        }   

        // Function to close the modal
            function closePreview() {
                document.getElementById("previewModal").style.display = "none";
            }

            // Close modal when clicking outside the content
            document.getElementById("previewModal").addEventListener("click", function (event) {
                if (event.target === this) {
                    closePreview();
                }
            });
    </script>

</body>
</html>

<footer>
<?php
    mysqli_close($conn); 
?>
<?php
include("footer.html")

?>
</footer>