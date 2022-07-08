export default {
  text: {
    light: 'text-gray-50 hover:text-gray-100',
    dark: 'text-gray-700 hover:text-gray-800',
    success: 'text-green-600 hover:text-green-700',
    danger: 'text-red-600 hover:text-red-700',
    info: 'text-yellow-600 hover:text-yellow-700',
    new: 'text-blue-600 hover:text-blue-700',
  },
  colors: {
    light: 'bg-white hover:bg-gray-50 text-gray-700',
    dark: 'bg-gray-700 hover:bg-gray-500 text-white',
    success: 'bg-green-600 hover:bg-green-700 text-white',
    danger: 'bg-red-600 hover:bg-red-700 text-white',
    info: 'bg-yellow-600 hover:bg-yellow-700 text-white',
    new: 'bg-blue-600 hover:bg-blue-700 text-white',
  },
  rings: {
    base: 'focus:outline-none focus:ring-2 focus:ring-offset-2',
    light: '@bread(rings.base) focus:ring-gray-200 ',
    dark: '@bread(rings.base) focus:ring-gray-500 ',
    success: '@bread(rings.base) focus:ring-green-500 ',
    danger: '@bread(rings.base) focus:ring-red-500 ',
    info: '@bread(rings.base) focus:ring-yellow-500 ',
    new: '@bread(rings.base) focus:ring-blue-500 ',
  },
  buttons: {
    base: 'inline-flex w-full justify-center rounded-md border border-transparent px-4 py-2 text-base font-medium text-white shadow-sm sm:col-start-2 sm:text-sm',
    light:
      '@bread(buttons.base) @bread(colors.light) @bread(rings.light) border-gray-100',
    dark: '@bread(buttons.base) @bread(colors.dark) @bread(rings.dark)',
    success:
      '@bread(buttons.base) @bread(colors.success) @bread(rings.success)',
    danger: '@bread(buttons.base) @bread(colors.danger) @bread(rings.danger)',
    info: '@bread(buttons.base) @bread(colors.info) @bread(rings.info)',
    new: '@bread(buttons.base) @bread(colors.new) @bread(rings.new)',
  },
}
