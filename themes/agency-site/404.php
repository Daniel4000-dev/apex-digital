<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Agency_Site
 */

get_header();
?>

<div class="py-24 lg:py-32 bg-gradient-to-b from-white via-agency-50/40 to-slate-50 flex items-center justify-center">
	<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
		<span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-700 uppercase tracking-widest mb-6">
			404 Error
		</span>
		<h1 class="text-5xl sm:text-6xl md:text-7xl font-extrabold text-slate-900 tracking-tight font-heading mb-6">
			Page Not Found
		</h1>
		<p class="text-lg text-slate-600 mb-10 leading-relaxed max-w-lg mx-auto">
			The page you are looking for may have been relocated, rebranded, or retired. Let’s get you back to high-converting territory.
		</p>

		<div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-12">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary !py-3.5 !px-8 text-sm w-full sm:w-auto">
				<span>Return to Homepage</span>
				<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
			</a>
			<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn-secondary !py-3.5 !px-8 text-sm w-full sm:w-auto">
				Explore Services
			</a>
		</div>

		<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-soft max-w-md mx-auto">
			<h2 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3">Or Search Our Site</h2>
			<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex gap-2">
				<input 
					type="search" 
					name="s" 
					placeholder="Search for solutions or articles..." 
					class="w-full px-4 py-2 rounded-xl border border-slate-200 text-slate-800 text-xs focus:outline-none focus:ring-2 focus:ring-agency-500"
				>
				<button type="submit" class="btn-primary !px-4 !py-2 text-xs">Search</button>
			</form>
		</div>
	</div>
</div>

<?php
get_footer();

