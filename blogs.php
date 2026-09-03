<?php
require_once __DIR__ . '/admin/includes/db.php';
include 'includes/headerScript.php';
include 'includes/header.php';

/* ==========================================================================
   FETCH ACTIVE, NON-DELETED BLOGS FROM MYSQL
   ========================================================================== */
$blogsQuery = "SELECT id, category, title, published_date, image, excerpt, content, read_time, created_at
               FROM blogs
               WHERE status = 1 AND is_deleted = 0
               ORDER BY published_date DESC, id DESC";

$blogsResult = mysqli_query($conn, $blogsQuery);

$blogs = [];
if ($blogsResult) {
    while ($row = mysqli_fetch_assoc($blogsResult)) {
        $blogs[] = $row;
    }
}

/* Map default legacy slugs for migrated blogs */
$slugMap = [
    1 => 'marine-engineering',
    2 => 'marine-safety',
    3 => 'offshore-engineering',
    4 => 'modular-systems'
];

/* Build dynamic dataset for client-side modal reading */
$blogsForJs = [];
foreach ($blogs as $b) {
    $imgSrc = !empty($b['image']) ? $b['image'] : 'assets/blog_shipbuilding_shipyard.jpg';
    if (!file_exists(__DIR__ . '/' . $imgSrc)) {
        $altJpg = preg_replace('/\.jpg$/i', '.jpeg', $imgSrc);
        if (file_exists(__DIR__ . '/' . $altJpg)) {
            $imgSrc = $altJpg;
        } else {
            $altJpeg = preg_replace('/\.jpeg$/i', '.jpg', $imgSrc);
            if (file_exists(__DIR__ . '/' . $altJpeg)) {
                $imgSrc = $altJpeg;
            }
        }
    }

    $readTimeText = !empty($b['read_time']) ? (int)$b['read_time'] . ' min read' : '3 min read';
    $slug = $slugMap[(int)$b['id']] ?? '';

    $blogsForJs[] = [
        'id'        => (string)$b['id'],
        'slug'      => $slug,
        'category'  => strtoupper($b['category']),
        'title'     => $b['title'],
        'summary'   => $b['excerpt'],
        'image'     => $imgSrc,
        'alt'       => $b['title'],
        'readTime'  => $readTimeText,
        'content'   => $b['content']
    ];
}
?>

  <!-- MAIN BLOGS CONTENT -->
  <main class="main-content" style="padding-top: calc(var(--header-height, 84px) + 2rem);">

    <section class="blogs-section site-section" id="blogs" aria-label="Insights and Knowledge" style="padding-top: 2rem;">
      <div class="blogs-container">

        <!-- Header -->
        <div class="blogs-header">
          <div class="blogs-pretag">
            <span class="pretag-dot"></span>
            <span>INSIGHTS &amp; KNOWLEDGE</span>
          </div>
          <h1 class="blogs-headline" style="font-size: 2.3rem;">
            TECHNICAL INSIGHTS &amp; EXPERT KNOWLEDGE
          </h1>
          <p class="blogs-desc">
            Explore key engineering insights, fire safety standards, and modern modular accommodation practices for
            marine and offshore applications.
          </p>
        </div>

        <!-- Blog Cards Grid -->
        <div class="blogs-grid">

        <?php if (!empty($blogs)) { ?>
          <?php foreach ($blogs as $blog) {
              /* Format published date */
              $displayDate = '';
              if (!empty($blog['published_date']) && $blog['published_date'] !== '0000-00-00') {
                  $timestamp = strtotime($blog['published_date']);
                  if ($timestamp) {
                      $displayDate = strtoupper(date('d M Y', $timestamp));
                  }
              }
              if ($displayDate === '' && !empty($blog['created_at'])) {
                  $timestamp = strtotime($blog['created_at']);
                  if ($timestamp) {
                      $displayDate = strtoupper(date('d M Y', $timestamp));
                  }
              }

              /* Image path verification and fallback */
              $imgSrc = !empty($blog['image']) ? $blog['image'] : 'assets/blog_shipbuilding_shipyard.jpg';
              if (!file_exists(__DIR__ . '/' . $imgSrc)) {
                  $altJpg = preg_replace('/\.jpg$/i', '.jpeg', $imgSrc);
                  if (file_exists(__DIR__ . '/' . $altJpg)) {
                      $imgSrc = $altJpg;
                  } else {
                      $altJpeg = preg_replace('/\.jpeg$/i', '.jpg', $imgSrc);
                      if (file_exists(__DIR__ . '/' . $altJpeg)) {
                          $imgSrc = $altJpeg;
                      }
                  }
              }
              $blogId = (int)$blog['id'];
              $slug = $slugMap[$blogId] ?? (string)$blogId;
          ?>
          <article class="blog-card" id="blog-card-<?php echo $blogId; ?>">
            <div class="blog-card-media">
              <img src="<?php echo htmlspecialchars($imgSrc); ?>"
                alt="<?php echo htmlspecialchars($blog['title']); ?>" class="blog-card-img"
                loading="lazy">
              <div class="blog-card-overlay"></div>
            </div>
            <div class="blog-card-body">
              <span class="blog-category-tag"><?php echo htmlspecialchars(strtoupper($blog['category'])); ?></span>
              <?php if ($displayDate !== '') { ?>
              <span class="blog-card-date"><?php echo htmlspecialchars($displayDate); ?></span>
              <?php } ?>
              <br>
              <h3 class="blog-card-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
              <p class="blog-card-summary">
                <?php echo htmlspecialchars($blog['excerpt']); ?>
              </p>
              <button type="button" class="btn-read-blog" data-blog-id="<?php echo $blogId; ?>"
                onclick="openBlogArticle('<?php echo $blogId; ?>')"
                aria-label="Read article: <?php echo htmlspecialchars($blog['title']); ?>">
                <span>READ ARTICLE</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </article>
          <?php } ?>
        <?php } else { ?>
          <p style="grid-column: 1 / -1; text-align: center; color: #94a3b8; padding: 2rem 0;">
            No articles published yet. Please check back soon.
          </p>
        <?php } ?>

        </div>

      </div>
    </section>

  </main>

  <!-- Premium Blog Article Reading Modal Overlay -->
  <div id="blog-modal" class="blog-modal" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="modal-blog-title">
    <div class="blog-modal-backdrop" id="blog-modal-backdrop" onclick="closeBlogModal()" aria-hidden="true"></div>
    <div class="blog-modal-container">
      <button type="button" class="blog-modal-close-btn" id="blog-modal-close" onclick="closeBlogModal()" aria-label="Close article modal">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18" />
          <line x1="6" y1="6" x2="18" y2="18" />
        </svg>
      </button>

      <div class="blog-modal-header">
        <img id="modal-blog-image" src="assets/ship_cutaway_hero_1787745117157.jpg" alt="Blog feature header"
          class="blog-modal-img">
        <div class="blog-modal-img-overlay"></div>
      </div>

      <div class="blog-modal-content">
        <div class="modal-meta-row">
          <span class="modal-category-tag" id="modal-blog-category">MARINE ENGINEERING</span>
          <span class="modal-readtime" id="modal-blog-readtime">4 min read</span>
        </div>
        <h2 class="blog-modal-title" id="modal-blog-title">Why Marine Accommodation Systems Matter in Modern
          Shipbuilding</h2>
        <div class="modal-blog-body" id="modal-blog-body">
          <!-- Populated dynamically -->
        </div>
      </div>
    </div>
  </div>

  <script>
    window.BLOG_ARTICLES_DATA = <?php echo json_encode($blogsForJs, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP); ?>;

    function openBlogArticle(id) {
      const modal = document.getElementById('blog-modal');
      if (!modal) return;
      const articles = window.BLOG_ARTICLES_DATA || [];
      const blogData = articles.find(function(b) {
        return String(b.id) === String(id) || (b.slug && String(b.slug) === String(id));
      });
      if (!blogData) return;

      const modalCategory = document.getElementById('modal-blog-category');
      const modalTitle = document.getElementById('modal-blog-title');
      const modalImage = document.getElementById('modal-blog-image');
      const modalReadTime = document.getElementById('modal-blog-readtime');
      const modalBody = document.getElementById('modal-blog-body');
      const modalCloseBtn = document.getElementById('blog-modal-close');

      if (modalCategory) modalCategory.textContent = blogData.category;
      if (modalTitle) modalTitle.textContent = blogData.title;
      if (modalReadTime) modalReadTime.textContent = blogData.readTime;
      if (modalImage) {
        modalImage.src = blogData.image;
        modalImage.alt = blogData.alt || blogData.title;
      }
      if (modalBody) {
        modalBody.innerHTML = '';
        if (blogData.content) {
          modalBody.innerHTML = blogData.content;
        } else if (Array.isArray(blogData.paragraphs)) {
          blogData.paragraphs.forEach(function(pText) {
            if (pText.startsWith('•')) {
              const ul = document.createElement('ul');
              ul.className = 'modal-blog-list';
              const items = pText.split('\n');
              items.forEach(function(item) {
                const li = document.createElement('li');
                const cleanText = item.replace(/^•\s*/, '');
                if (cleanText.includes(':')) {
                  const parts = cleanText.split(':');
                  li.innerHTML = '<strong>' + parts[0] + ':</strong>' + parts.slice(1).join(':');
                } else {
                  li.textContent = cleanText;
                }
                ul.appendChild(li);
              });
              modalBody.appendChild(ul);
            } else {
              const p = document.createElement('p');
              p.className = 'modal-blog-paragraph';
              p.textContent = pText;
              modalBody.appendChild(p);
            }
          });
        }
      }

      modal.classList.add('active');
      document.body.classList.add('modal-open');
      modal.setAttribute('aria-hidden', 'false');
      if (modalCloseBtn) modalCloseBtn.focus();
    }

    function closeBlogModal() {
      const modal = document.getElementById('blog-modal');
      if (!modal) return;
      modal.classList.remove('active');
      document.body.classList.remove('modal-open');
      modal.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeBlogModal();
      }
    });
  </script>

<?php include 'includes/footer.php'; ?>
