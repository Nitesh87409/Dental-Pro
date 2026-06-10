<?php
/**
 * Template Part: Clinic 360 Virtual Tour Section
 *
 * @package developer-starter-pro
 * @since   1.0.0
 */
?>

<section class="developer-starter-pro-section virtual-tour-section" id="virtual-tour" style="background: var(--developer-starter-pro-gray-50); overflow: hidden; position: relative; padding: 100px 0;">
	<div class="developer-starter-pro-container">

		<!-- Section Header -->
		<div class="developer-starter-pro-section-header">
			<span class="developer-starter-pro-section-badge"><?php esc_html_e( 'Interactive Tour', 'developer-starter-pro' ); ?></span>
			<h2 class="developer-starter-pro-section-title"><?php esc_html_e( 'Explore Our Modern Facilities', 'developer-starter-pro' ); ?></h2>
			<p class="developer-starter-pro-section-subtitle"><?php esc_html_e( 'Take a virtual 360-degree walk inside our clinical surgical suites, sterilization areas, and patient comfort rooms.', 'developer-starter-pro' ); ?></p>
		</div>

		<!-- Tour Viewer Frame -->
		<div class="tour-viewer-frame" style="background: var(--developer-starter-pro-secondary); border-radius: var(--developer-starter-pro-radius-lg); border: 4px solid var(--developer-starter-pro-white); box-shadow: var(--developer-starter-pro-shadow-xl); overflow: hidden; position: relative; aspect-ratio: 16/9; max-width: 1000px; margin: 40px auto 0 auto;">
			
			<!-- Virtual Tour Wide Container (holds panoramic SVG) -->
			<div class="tour-panoramic-container" id="tour-panoramic-container" style="width: 2400px; height: 100%; position: absolute; left: -600px; top: 0; background: url('<?php echo esc_url( developer_starter_pro_IMAGES . '/tour-panoramic.svg' ); ?>') no-repeat center center; background-size: cover; cursor: grab; transition: transform 0.1s ease; user-select: none;">
				
				<!-- Interactive Hotspots -->

				<!-- Hotspot 1: Dental Light -->
				<div class="tour-hotspot" style="position: absolute; left: 1000px; top: 120px;" data-title="<?php esc_attr_e( 'LED Surgical Lamp', 'developer-starter-pro' ); ?>" data-desc="<?php esc_attr_e( 'Shadowless medical illumination featuring cool LED array technology to ensure maximum diagnostic precision and minimal eye fatigue.', 'developer-starter-pro' ); ?>">
					<span class="hotspot-pulse"></span>
					<span class="hotspot-icon">💡</span>
				</div>

				<!-- Hotspot 2: Operatory Chair -->
				<div class="tour-hotspot" style="position: absolute; left: 1150px; top: 250px;" data-title="<?php esc_attr_e( 'AeroSoft Treatment Chair', 'developer-starter-pro' ); ?>" data-desc="<?php esc_attr_e( 'Ergonomic pressure-contour cushioning with full orthopedic support, dynamic pediatric sizing, and stress-reducing massage modes.', 'developer-starter-pro' ); ?>">
					<span class="hotspot-pulse"></span>
					<span class="hotspot-icon">🦷</span>
				</div>

				<!-- Hotspot 3: Sterilization Cabinets -->
				<div class="tour-hotspot" style="position: absolute; left: 350px; top: 210px;" data-title="<?php esc_attr_e( 'Class-B Autoclave Sterilizer', 'developer-starter-pro' ); ?>" data-desc="<?php esc_attr_e( 'Hospital-grade instrument sterilization and vacuum purification area, adhering to strict CDC sanitary protocols.', 'developer-starter-pro' ); ?>">
					<span class="hotspot-pulse"></span>
					<span class="hotspot-icon">🛡️</span>
				</div>

				<!-- Hotspot 4: Window View -->
				<div class="tour-hotspot" style="position: absolute; left: 1950px; top: 130px;" data-title="<?php esc_attr_e( 'Therapeutic Nature Viewing Window', 'developer-starter-pro' ); ?>" data-desc="<?php esc_attr_e( 'Double-paned soundproof windows overlooking our garden path, proven to lower heart rates and distract anxious pediatric patients.', 'developer-starter-pro' ); ?>">
					<span class="hotspot-pulse"></span>
					<span class="hotspot-icon">🌿</span>
				</div>

			</div>

			<!-- Live Tooltip Overlay -->
			<div class="tour-tooltip" id="tour-tooltip" style="position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%) translateY(20px); width: 90%; max-width: 500px; background: rgba(30, 41, 59, 0.95); border: 1px solid rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); border-radius: 12px; padding: 20px; color: #fff; box-shadow: 0 10px 30px rgba(0,0,0,0.5); opacity: 0; pointer-events: none; transition: all 0.3s ease; text-align: left; z-index: 100;">
				<h4 class="tooltip-title" style="margin: 0 0 6px 0; color: var(--developer-starter-pro-primary); font-size: 1.1rem; font-family: var(--developer-starter-pro-font-heading);"></h4>
				<p class="tooltip-desc" style="margin: 0; color: #cbd5e1; font-size: 0.875rem; line-height: 1.5;"></p>
			</div>

			<!-- Navigation Controls -->
			<button class="tour-nav-btn tour-nav-left" id="tour-nav-left" aria-label="<?php esc_attr_e( 'Scroll left', 'developer-starter-pro' ); ?>" style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(30,41,59,0.7); border: 1px solid rgba(255,255,255,0.2); color: #fff; font-size: 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); transition: background 0.2s, transform 0.2s; z-index: 10;">◀</button>
			
			<button class="tour-nav-btn tour-nav-right" id="tour-nav-right" aria-label="<?php esc_attr_e( 'Scroll right', 'developer-starter-pro' ); ?>" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(30,41,59,0.7); border: 1px solid rgba(255,255,255,0.2); color: #fff; font-size: 1.25rem; cursor: pointer; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); transition: background 0.2s, transform 0.2s; z-index: 10;">▶</button>

			<!-- Drag Icon Overlay Hint -->
			<div class="tour-drag-hint" id="tour-drag-hint" style="position: absolute; top: 20px; right: 20px; background: rgba(15,23,42,0.8); padding: 8px 14px; border-radius: 20px; color: #fff; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 6px; pointer-events: none; transition: opacity 0.3s ease;">
				<span>↔</span> <?php esc_html_e( 'Drag or use buttons to look around', 'developer-starter-pro' ); ?>
			</div>

		</div>

	</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	var container = document.getElementById('tour-panoramic-container');
	var frame = container.parentElement;
	var tooltip = document.getElementById('tour-tooltip');
	var dragHint = document.getElementById('tour-drag-hint');
	var titleEl = tooltip.querySelector('.tooltip-title');
	var descEl = tooltip.querySelector('.tooltip-desc');
	
	var leftPos = -600; // Starting center position offset
	var minLeft = -(2400 - frame.clientWidth); // Maximum boundary
	var maxLeft = 0; // Minimum boundary

	// Update boundaries on window resize
	function updateBoundaries() {
		minLeft = -(2400 - frame.clientWidth);
		if (leftPos < minLeft) {
			leftPos = minLeft;
			container.style.left = leftPos + 'px';
		}
	}
	window.addEventListener('resize', updateBoundaries);
	updateBoundaries();

	// Button navigation triggers
	document.getElementById('tour-nav-left').addEventListener('click', function() {
		leftPos += 200;
		if (leftPos > maxLeft) leftPos = maxLeft;
		container.style.left = leftPos + 'px';
		hideTooltip();
		hideHint();
	});

	document.getElementById('tour-nav-right').addEventListener('click', function() {
		leftPos -= 200;
		if (leftPos < minLeft) leftPos = minLeft;
		container.style.left = leftPos + 'px';
		hideTooltip();
		hideHint();
	});

	// Drag to explore logic
	var isDragging = false;
	var startX = 0;
	var startLeft = 0;

	container.addEventListener('mousedown', function(e) {
		isDragging = true;
		startX = e.clientX;
		startLeft = leftPos;
		container.style.cursor = 'grabbing';
		hideTooltip();
		hideHint();
		e.preventDefault();
	});

	window.addEventListener('mousemove', function(e) {
		if (!isDragging) return;
		var dx = e.clientX - startX;
		leftPos = startLeft + dx;
		if (leftPos > maxLeft) leftPos = maxLeft;
		if (leftPos < minLeft) leftPos = minLeft;
		container.style.left = leftPos + 'px';
	});

	window.addEventListener('mouseup', function() {
		if (isDragging) {
			isDragging = false;
			container.style.cursor = 'grab';
		}
	});

	// Touch supports for mobile viewports
	container.addEventListener('touchstart', function(e) {
		isDragging = true;
		startX = e.touches[0].clientX;
		startLeft = leftPos;
		hideTooltip();
		hideHint();
	});

	container.addEventListener('touchmove', function(e) {
		if (!isDragging) return;
		var dx = e.touches[0].clientX - startX;
		leftPos = startLeft + dx;
		if (leftPos > maxLeft) leftPos = maxLeft;
		if (leftPos < minLeft) leftPos = minLeft;
		container.style.left = leftPos + 'px';
	});

	container.addEventListener('touchend', function() {
		isDragging = false;
	});

	// Interactive hotspot mouseover
	var hotspots = container.querySelectorAll('.tour-hotspot');
	hotspots.forEach(function(hotspot) {
		hotspot.addEventListener('click', function(e) {
			e.stopPropagation();
			var title = hotspot.getAttribute('data-title');
			var desc = hotspot.getAttribute('data-desc');
			showTooltip(title, desc);
		});
		hotspot.addEventListener('mouseenter', function() {
			var title = hotspot.getAttribute('data-title');
			var desc = hotspot.getAttribute('data-desc');
			showTooltip(title, desc);
		});
	});

	// Click anywhere else in viewer to close tooltip
	frame.addEventListener('click', function() {
		hideTooltip();
	});

	function showTooltip(title, desc) {
		titleEl.textContent = title;
		descEl.textContent = desc;
		tooltip.style.opacity = '1';
		tooltip.style.transform = 'translateX(-50%) translateY(0)';
	}

	function hideTooltip() {
		tooltip.style.opacity = '0';
		tooltip.style.transform = 'translateX(-50%) translateY(20px)';
	}

	function hideHint() {
		if (dragHint) {
			dragHint.style.opacity = '0';
		}
	}
});
</script>

<style>
/* Hotspot pulsing keyframe animations */
.tour-hotspot {
	width: 34px;
	height: 34px;
	background: var(--developer-starter-pro-primary);
	border: 2px solid #fff;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	color: #fff;
	font-size: 0.875rem;
	cursor: pointer;
	box-shadow: 0 4px 10px rgba(0,0,0,0.3);
	z-index: 5;
	transition: transform 0.2s ease;
}
.tour-hotspot:hover {
	transform: scale(1.2);
	background: var(--developer-starter-pro-accent);
}
.hotspot-pulse {
	position: absolute;
	width: 100%;
	height: 100%;
	border-radius: 50%;
	border: 3px solid var(--developer-starter-pro-primary);
	opacity: 0.6;
	animation: hotspotPulse 1.8s infinite;
}
@keyframes hotspotPulse {
	0% { transform: scale(1); opacity: 0.8; }
	100% { transform: scale(2.2); opacity: 0; }
}
.tour-nav-btn:hover {
	background: rgba(30,41,59,0.95) !important;
	transform: translateY(-50%) scale(1.08);
}
body.dark-mode .virtual-tour-section {
	background: #0F172A !important;
}
body.dark-mode .tour-viewer-frame {
	border-color: #334155 !important;
}
body.dark-mode .tour-tooltip {
	background: rgba(15, 23, 42, 0.95) !important;
	border-color: #334155 !important;
}
</style>
