/** @type {import('tailwindcss').Config} */
export default {
	content: ['./resources/**/*.blade.php', './resources/**/*.vue'],
	theme: {
		extend: {
			transitionDelay: {
				500: '500ms',
				600: '600ms',
				700: '700ms',
				800: '800ms',
				900: '900ms',
				1000: '1000ms',
				1100: '1100ms',
				1200: '1200ms',
				1300: '1300ms',
				1400: '1400ms',
				1500: '1500ms',
				1600: '1600ms',
				1700: '1700ms',
				1800: '1800ms',
				1900: '1900ms',
				2000: '2000ms',
			}
		}
	},
	plugins: [],
};
