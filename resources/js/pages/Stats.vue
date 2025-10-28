<script setup>
import { computed } from 'vue';

const props = defineProps({
	stats: Array
});
</script>

<template>
	<div class="min-h-screen text-white p-4 max-w-xl mx-auto">
		<!-- Logo -->
		<div class="w-full flex justify-center mb-6">
			<a href="/" class="w-48">
				<img
					src="/img/RBW_logo_transparent.png"
					alt="Red Barn Worship Logo"
					class="w-full h-full object-contain rounded-2xl"
				/>
			</a>
		</div>

		<!-- Title -->
		<h1 class="text-2xl font-bold text-center mb-8 tracking-wide text-gray-100">
			Page View Statistics
		</h1>

		<!-- Stats Cards -->
		<div v-for="stat in props.stats" :key="stat.route" class="mb-8 border-2 px-4 py-2 rounded-lg border-gray-800">
			<!-- Header -->
			<div class="flex justify-between items-center mb-3">
				<h2 class="text-xl font-semibold text-white capitalize">
					{{ stat.route }}
				</h2>
				<!-- <div class="text-3xl font-bold text-red-400">
					{{ stat.total_all_time }}
				</div> -->
			</div>

			<!-- Table Header -->
			<div class="grid grid-cols-4 text-sm text-gray-400 mb-2 border-b border-gray-700 pb-1">
				<div>Date</div>
				<div class="text-blue-400 text-right">Insta/FB</div>
				<div class="text-green-400 text-right">Other</div>
				<div class="text-gray-300 text-right">Total</div>
			</div>

			<!-- Daily Breakdown -->
			<div v-for="(day, date) in stat.by_day" :key="date"
				class="grid grid-cols-4 text-sm py-1 border-b last:border-red-500 border-gray-800">
				<div class="font-mono text-gray-300">{{ date }}</div>
				<div class="text-blue-300 text-right">
					{{ day.fbclid ?? 0 }}
				</div>
				<div class="text-green-300 text-right">
					{{ day.other ?? (typeof day === 'number' ? day : 0) }}
				</div>
				<div class="text-gray-100 text-right font-semibold">
					{{ (day.fbclid ?? 0) + (day.other ?? (typeof day === 'number' ? day : 0)) }}
				</div>
			</div>

			<!-- Totals Row -->
			<div class="grid grid-cols-4 text-sm font-semibold pt-2 border-t border-gray-700 mt-2">
				<div class="text-gray-400">Totals</div>
				<div class="text-blue-400 text-right">{{ stat.fbclid_sum }}</div>
				<div class="text-green-400 text-right">{{ stat.other_sum }}</div>
				<div class="text-red-500 text-right">{{ stat.total_all_time }}</div>
			</div>

			<!-- Averages Row -->
			<div class="grid grid-cols-4 text-sm font-semibold pt-2 mt-2 border-t border-gray-700">
				<div class="text-gray-400">Avg / Day</div>
				<div class="text-blue-400 text-right">{{ stat.avg_fbclid }}</div>
				<div class="text-green-400 text-right">{{ stat.avg_other }}</div>
				<div class="text-gray-200 text-right">{{ stat.avg_total }}</div>
			</div>
		</div>
	</div>
</template>

<style scoped>
summary::-webkit-details-marker {
	display: none;
}
summary {
	list-style: none;
}
</style>
