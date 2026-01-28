<template>
	<div class="members-list">
		<div class="header-actions">
			<button @click="$emit('select-member', null)">Neues Mitglied</button>
		</div>
		<div v-if="loading" class="loading">Suche Mitglieder...</div>
		<table v-else class="members-table">
			<thead>
				<tr>
					<th>Nachname</th>
					<th>Vorname</th>
					<th>Status</th>
					<th>Eintritt</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="member in members" :key="member.id" @click="$emit('select-member', member.id)">
					<td>{{ member.lastname }}</td>
					<td>{{ member.firstname }}</td>
					<td>
						<span :class="['status-badge', member.status]">{{ member.status }}</span>
					</td>
					<td>{{ formatDate(member.joinedAt) }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
	name: 'Members',
	data() {
		return {
			members: [],
			loading: true
		}
	},
	mounted() {
		this.fetchdata()
	},
	methods: {
		async fetchdata() {
			this.loading = true
			try {
				const response = await axios.get(generateUrl('/apps/clubsuite-core/members'))
				this.members = response.data
			} catch (e) {
				console.error(e)
			} finally {
				this.loading = false
			}
		},
		formatDate(dateStr) {
			if (!dateStr) return '-'
			return new Date(dateStr).toLocaleDateString()
		}
	}
}
</script>

<style scoped>
.members-list { padding: 20px; }
.header-actions { margin-bottom: 20px; display: flex; justify-content: flex-end; }
.members-table { width: 100%; border-collapse: collapse; }
.members-table tr { cursor: pointer; }
.members-table tr:hover { background-color: var(--color-background-hover); }
.members-table td, .members-table th { padding: 10px; border-bottom: 1px solid var(--color-border); text-align: left; }
.status-badge { padding: 2px 6px; border-radius: 4px; font-size: 0.9em; }
.status-badge.active { background-color: var(--color-success); color: white; }
.status-badge.passive { background-color: var(--color-text-maxcontrast); color: var(--color-text-light); }
</style>
