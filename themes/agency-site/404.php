<?php
/**
 * The template for displaying 404 pages (Not Found): Editorial Studio Aesthetic
 *
 * @package Agency_Site
 */

get_header();
?>

<div class="py-24 lg:py-32 bg-ivory flex items-center justify-center">
	<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="editorial-tag !text-coral !border-coral mb-6">
			404 / NOT FOUND
		</span>
		<h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-ink tracking-tight font-heading mb-6">
			Page Not Found
		</h1>
		<p class="text-lg text-ink/80 mb-10 leading-relaxed max-w-lg mx-auto font-normal">
			The page or resource you requested may have been relocated, restructured, or retired. Return to our index or search the knowledgebase.
		</p>

		<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary !py-3.5 !px-8 text-xs uppercase tracking-wider font-semibold w-full sm:w-auto">
				<span>Return to Index</span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
			</a>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-secondary !py-3.5 !px-8 text-xs uppercase tracking-wider font-semibold w-full sm:w-auto">
				Explore Services
			</a>
		</div>

		<div class="border border-ink/20 p-6 bg-ivory max-w-md mx-auto text-left">
			<h2 class="font-mono text-xs uppercase tracking-widest text-ink/60 mb-3">Or Search Our Site</h2>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
				<input 
					type="search" 
					name="s" 
					placeholder="Search for capabilities or articles..." 
					class="w-full px-3 py-2 bg-ivory border border-ink/20 text-ink text-xs focus:outline-none focus:border-cobalt font-mono"
				>
				<button type="submit" class="btn-primary !px-4 !py-2 text-xs uppercase font-mono">Search</button>
			</form>
		</div>
	</div>
</div>

<?php
get_footer();
