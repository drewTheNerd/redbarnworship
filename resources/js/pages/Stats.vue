<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
	stats: Array
});

// Sort routes alphabetically
const sortedStats = computed(() => {
	return [...props.stats].sort((a, b) => a.route.localeCompare(b.route));
});

// Track expanded state for each route
const expanded = ref({});

function toggleExpand(route) {
	expanded.value[route] = !expanded.value[route];
}
</script>

<template>
	<div class="min-h-screen max-w-lg mx-auto text-white py-4 px-2">
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

		<h1 class="text-2xl font-bold text-center mb-8 tracking-wide text-gray-100">
			Page View Statistics
		</h1>

		<!-- Stats Cards -->
		<div
			v-for="stat in sortedStats"
			:key="stat.route"
			class="mb-8 border-2 px-3 py-2 rounded-lg border-gray-800"
		>
			<!-- Header -->
			<div class="flex justify-between items-center mb-3 cursor-pointer" @click="toggleExpand(stat.route)">
				<h2 class="text-xl font-semibold text-white capitalize flex items-center gap-2">
					{{ stat.route }}
				</h2>
				<div class="text-xl">
					<i
						class="fa-solid fa-chevron-down transition-transform duration-200"
						:class="expanded[stat.route] ? 'rotate-0' : 'rotate-90'"
					></i>
				</div>
			</div>

			<!-- Table Header -->
			<transition name="fade">
				<div
					v-if="expanded[stat.route]"
					class="flex text-sm text-gray-400 mb-2 border-b border-gray-700 pb-1"
				>
					<div class="flex-1">Date</div>
					<div class="w-14 text-right text-blue-400">Insta/FB</div>
					<div class="w-14 text-right text-purple-400">QR</div>
					<div class="w-14 text-right text-green-400">Other</div>
					<div class="w-14 text-right text-gray-300">Total</div>
				</div>
			</transition>

			<!-- Daily Breakdown -->
			<transition name="fade">
				<div v-if="expanded[stat.route]">
					<div
						v-for="(day, date) in stat.by_day"
						:key="date"
						class="flex text-sm py-1 border-b last:border-0 border-gray-800"
					>
						<div class="flex-1 font-mono text-gray-300 truncate">{{ date }}</div>
						<div class="w-14 text-blue-300 text-right">
							{{ day.fbclid ?? 0 }}
						</div>
						<div class="w-14 text-purple-300 text-right">
							{{ day.qr ?? 0 }}
						</div>
						<div class="w-14 text-green-300 text-right">
							{{ day.other ?? (typeof day === 'number' ? day : 0) }}
						</div>
						<div class="w-14 text-gray-100 text-right font-semibold">
							{{ (day.fbclid ?? 0) + (day.qr ?? 0) + (day.other ?? (typeof day === 'number' ? day : 0)) }}
						</div>
					</div>
				</div>
			</transition>

			<!-- Totals Row -->
			<div class="flex text-sm font-semibold pt-2 border-t border-gray-700 mt-2">
				<div class="flex-1 text-gray-400">Totals</div>
				<div class="w-14 text-right text-blue-400">{{ stat.fbclid_sum }}</div>
				<div class="w-14 text-right text-purple-400">{{ stat.qr_sum }}</div>
				<div class="w-14 text-right text-green-400">{{ stat.other_sum }}</div>
				<div class="w-14 text-right text-red-500">{{ stat.total_all_time }}</div>
			</div>

			<!-- Averages Row -->
			<div class="flex text-sm font-semibold pt-2 mt-2 border-t border-gray-700">
				<div class="flex-1 text-gray-400">Avg / Day</div>
				<div class="w-14 text-right text-blue-400">{{ stat.avg_fbclid }}</div>
				<div class="w-14 text-right text-purple-400">{{ stat.avg_qr }}</div>
				<div class="w-14 text-right text-green-400">{{ stat.avg_other }}</div>
				<div class="w-14 text-right text-gray-200">{{ stat.avg_total }}</div>
			</div>

		</div>
	</div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
	transition: opacity 0.2s ease;
}
.fade-enter-from,
.fade-leave-to {
	opacity: 0;
}
</style>
