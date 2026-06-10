<?php
/**
 * Template Name: Gallery
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */

get_header();
?>

<main id="primary" class="developer-starter-pro-main" role="main">

	<!-- Page Header -->
	<div class="developer-starter-pro-page-banner">
		<div class="developer-starter-pro-container">
			<div class="developer-starter-pro-section-header" style="margin-bottom: 0; padding: 48px 0;">
				<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Our Showcase', 'developer-starter-pro' ); ?></span>
				<h1 class="developer-starter-pro-section-title"><?php the_title(); ?></h1>
				<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Take a virtual tour of our modern facilities, state-of-the-art diagnostic dental equipment, and clinic environment.', 'developer-starter-pro' ); ?></p>
			</div>
		</div>
	</div>

	<!-- Gallery Section -->
	<section class="developer-starter-pro-section">
		<div class="developer-starter-pro-container">
			
			<div class="developer-starter-pro-gallery-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
				<!-- Static placeholder images indicating beautiful visual structure -->
				<?php for ( $i = 1; $i <= 6; $i++ ) : 
					$titles = array(
						1 => __( 'Modern Patient Room', 'developer-starter-pro' ),
						2 => __( 'Laser Treatment Suite', 'developer-starter-pro' ),
						3 => __( 'Advanced 3D X-Ray Scanner', 'developer-starter-pro' ),
						4 => __( 'Comfortable Lobby Area', 'developer-starter-pro' ),
						5 => __( 'Sterilization Laboratory', 'developer-starter-pro' ),
						6 => __( 'Pediatric Dentistry Room', 'developer-starter-pro' ),
					);
				?>
					<div class="developer-starter-pro-gallery-item" style="position:relative; overflow:hidden; border-radius:12px; aspect-ratio: 4/3; cursor:pointer; box-shadow: var(--developer-starter-pro-shadow-md); transition: var(--developer-starter-pro-transition);">
						<div class="gallery-placeholder-img" style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background: var(--developer-starter-pro-gray-100); color: var(--developer-starter-pro-gray-400); font-size:3rem;">
							📸
						</div>
						<div class="gallery-overlay" style="position:absolute; inset:0; background: rgba(15, 23, 42, 0.7); display:flex; flex-direction:column; align-items:center; justify-content:center; opacity:0; transition: var(--developer-starter-pro-transition); color:#fff; padding: 20px; text-align:center;" data-src="" data-title="<?php echo esc_attr( $titles[$i] ); ?>">
							<span class="zoom-icon" style="font-size:1.75rem; margin-bottom:8px;">🔍</span>
							<h3 style="color:#fff; font-size:1.1rem; margin:0;"><?php echo esc_html( $titles[$i] ); ?></h3>
						</div>
					</div>
				<?php endfor; ?>
			</div>

		</div>
	</section>

	<!-- Lightbox Modal container -->
	<div class="developer-starter-pro-lightbox" id="gallery-lightbox" style="position:fixed; inset:0; background: rgba(15,23,42,0.95); z-index:99999; display:none; align-items:center; justify-content:center; padding: 20px;">
		<span class="lightbox-close" style="position:absolute; top:30px; right:30px; font-size:2.5rem; color:#fff; cursor:pointer; user-select:none;">&times;</span>
		<span class="lightbox-prev" style="position:absolute; left:30px; font-size:3rem; color:#fff; cursor:pointer; user-select:none;">&#10094;</span>
		<span class="lightbox-next" style="position:absolute; right:30px; font-size:3rem; color:#fff; cursor:pointer; user-select:none;">&#10095;</span>
		<div class="lightbox-content" style="max-width:90%; max-height:80%; text-align:center;">
			<div class="lightbox-placeholder-img" style="font-size:8rem; color:#fff;">📸</div>
			<div class="lightbox-caption" style="color:#fff; margin-top:20px; font-size:1.25rem; font-weight:600; font-family: var(--developer-starter-pro-font-heading);"></div>
		</div>
	</div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var items = document.querySelectorAll('.developer-starter-pro-gallery-item');
	var lightbox = document.getElementById('gallery-lightbox');
	var caption = lightbox.querySelector('.lightbox-caption');
	var closeBtn = lightbox.querySelector('.lightbox-close');
	var prevBtn = lightbox.querySelector('.lightbox-prev');
	var nextBtn = lightbox.querySelector('.lightbox-next');
	
	var currentIndex = 0;

	function openLightbox(index) {
		currentIndex = index;
		var overlay = items[currentIndex].querySelector('.gallery-overlay');
		var title = overlay.getAttribute('data-title');
		caption.textContent = title;
		lightbox.style.display = 'flex';
		document.body.style.overflow = 'hidden';
	}

	function showNext() {
		currentIndex = (currentIndex + 1) % items.length;
		openLightbox(currentIndex);
	}

	function showPrev() {
		currentIndex = (currentIndex - 1 + items.length) % items.length;
		openLightbox(currentIndex);
	}

	items.forEach(function(item, index) {
		item.addEventListener('click', function() {
			openLightbox(index);
		});
	});

	closeBtn.addEventListener('click', function() {
		lightbox.style.display = 'none';
		document.body.style.overflow = '';
	});

	lightbox.addEventListener('click', function(e) {
		if (e.target === lightbox) {
			lightbox.style.display = 'none';
			document.body.style.overflow = '';
		}
	});

	nextBtn.addEventListener('click', function(e) {
		e.stopPropagation();
		showNext();
	});

	prevBtn.addEventListener('click', function(e) {
		e.stopPropagation();
		showPrev();
	});

	document.addEventListener('keydown', function(e) {
		if (lightbox.style.display === 'flex') {
			if (e.key === 'Escape') {
				lightbox.style.display = 'none';
				document.body.style.overflow = '';
			} else if (e.key === 'ArrowRight') {
				showNext();
			} else if (e.key === 'ArrowLeft') {
				showPrev();
			}
		}
	});
});
</script>

<?php
get_footer();
