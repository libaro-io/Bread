export default {
  colors: {
    success: 'bg-green-600 hover:bg-red-700',
    danger: 'bg-red-600 hover:bg-red-700',
    info: 'bg-blue-600 hover:bg-blue-700',
  },
  rings: {
    danger: '@bread(colors.danger) focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2'
  },
  buttons: {
    danger: ' @bread(rings.danger) inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm sm:col-start-2 sm:text-sm'
  },
}
