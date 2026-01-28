<template>
	<form @submit.prevent="save" class="member-form">
		<div class="form-group">
			<label>Vorname</label>
			<input type="text" v-model="localMember.firstname" required />
		</div>
		<div class="form-group">
			<label>Nachname</label>
			<input type="text" v-model="localMember.lastname" required />
		</div>
		<div class="form-group">
			<label>Email</label>
			<input type="email" v-model="localMember.email" />
		</div>
		<div class="form-group">
			<label>Status</label>
			<select v-model="localMember.status">
				<option value="active">Aktiv</option>
				<option value="passive">Passiv</option>
				<option value="honorary">Ehrenmitglied</option>
			</select>
		</div>
		<div class="actions">
			<button type="submit" class="primary">Speichern</button>
			<button type="button" @click="$emit('cancel')">Abbrechen</button>
		</div>
	</form>
</template>

<script>
export default {
	props: {
		member: {
			type: Object,
			default: () => ({ firstname: '', lastname: '', email: '', status: 'active' })
		}
	},
	data() {
		return {
			localMember: { ...this.member }
		}
	},
	watch: {
		member(newVal) {
			this.localMember = { ...newVal }
		}
	},
	methods: {
		save() {
			this.$emit('save', this.localMember)
		}
	}
}
</script>

<style scoped>
.form-group { margin-bottom: 15px; }
.form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
.form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid var(--color-border); border-radius: 4px; }
.actions { margin-top: 20px; display: flex; gap: 10px; }
button.primary { background-color: var(--color-primary); color: var(--color-primary-text); }
</style>
