import { createAppConfig } from '@nextcloud/vite-config'
import { join } from 'node:path'

export default createAppConfig({
	activate: join(__dirname, 'src', 'first-run.js'),
	about: join(__dirname, 'src', 'app-menu.js'),
})
