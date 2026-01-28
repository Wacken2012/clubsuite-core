<template>
  <NcContent app-name="clubsuite-core">
    <NcAppNavigation>
      <NcAppNavigationItem
        name="Mitglieder"
        :active="activeItem === 'members' || activeItem === 'memberDetail'"
        @click="showMembersList"
      >
        <template #icon>
          <AccountGroupIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Anträge"
        :href="appUrl('clubsuite-applications')"
      >
        <template #icon>
          <FileDocumentEditIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Noten"
        :href="appUrl('clubsuite-scores')"
      >
        <template #icon>
          <MusicIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Dokumente"
        :href="appUrl('clubsuite-documents')"
      >
        <template #icon>
          <FolderIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Training"
        :href="appUrl('clubsuite-training')"
      >
        <template #icon>
          <CalendarIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Newsletter"
        :href="appUrl('clubsuite-newsletter')"
      >
        <template #icon>
          <EmailIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Finanzen"
        :href="appUrl('clubsuite-finance')"
      >
        <template #icon>
          <CashIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Spenden"
        :href="appUrl('clubsuite-donations')"
      >
        <template #icon>
          <HandHeartIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Inventar"
        :href="appUrl('clubsuite-inventory')"
      >
        <template #icon>
          <PackageVariantIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Sitzungen"
        :href="appUrl('clubsuite-meetings')"
      >
        <template #icon>
          <ListBoxIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="SEPA"
        :href="appUrl('clubsuite-sepa')"
      >
        <template #icon>
          <CreditCardIcon :size="20" />
        </template>
      </NcAppNavigationItem>

      <NcAppNavigationItem
        name="Statistiken"
        :href="appUrl('clubsuite-stats')"
      >
        <template #icon>
          <ChartBarIcon :size="20" />
        </template>
      </NcAppNavigationItem>
    </NcAppNavigation>

    <NcAppContent>
      <div v-if="activeItem === 'members'" class="clubsuite-core-container">
        <h2>Mitgliederverwaltung</h2>
        <Members @select-member="showMemberDetail" />
      </div>
      <div v-if="activeItem === 'memberDetail'" class="clubsuite-core-container">
        <MemberDetail 
            ref="memberDetail"
            :id="selectedMemberId" 
            @back="showMembersList" 
            @edit="handleEditMember" 
        />
      </div>
    </NcAppContent>
    
    <MemberEditDialog 
        v-if="showEditDialog" 
        :member="editingMember" 
        @updated="onMemberUpdated" 
        @cancelled="closeEditDialog" 
    />
  </NcContent>
</template>

<script>
import { NcContent, NcAppNavigation, NcAppNavigationItem, NcAppContent } from '@nextcloud/vue'
import AccountGroupIcon from 'vue-material-design-icons/AccountGroup.vue'
import FileDocumentEditIcon from 'vue-material-design-icons/FileDocumentEdit.vue'
import MusicIcon from 'vue-material-design-icons/Music.vue'
import FolderIcon from 'vue-material-design-icons/Folder.vue'
import CalendarIcon from 'vue-material-design-icons/Calendar.vue'
import EmailIcon from 'vue-material-design-icons/Email.vue'
import CashIcon from 'vue-material-design-icons/Cash.vue'
import HandHeartIcon from 'vue-material-design-icons/HandHeart.vue'
import PackageVariantIcon from 'vue-material-design-icons/PackageVariant.vue'
import ListBoxIcon from 'vue-material-design-icons/ListBox.vue'
import CreditCardIcon from 'vue-material-design-icons/CreditCard.vue'
import ChartBarIcon from 'vue-material-design-icons/ChartBar.vue'
import Members from './views/Members.vue'
import MemberDetail from './views/MemberDetail.vue'
import MemberEditDialog from './components/MemberEditDialog.vue'
import { generateUrl } from '@nextcloud/router'

export default {
  name: 'App',
  components: {
    NcContent,
    NcAppNavigation,
    NcAppNavigationItem,
    NcAppContent,
    AccountGroupIcon,
    FileDocumentEditIcon,
    MusicIcon,
    FolderIcon,
    CalendarIcon,
    EmailIcon,
    CashIcon,
    HandHeartIcon,
    PackageVariantIcon,
    ListBoxIcon,
    CreditCardIcon,
    ChartBarIcon,
    Members,
    MemberDetail,
    MemberEditDialog
  },
  data() {
    return {
      activeItem: 'members',
      selectedMemberId: null,
      showEditDialog: false,
      editingMember: null
    }
  },
  methods: {
    appUrl(appId) {
        // Generate URL without trailing slash to let server handle it,
        // or ensure consistent behavior.
        const url = generateUrl('/apps/' + appId)
        return url
    },
    showMemberDetail(id) {
      if (id === null) {
        // New member: open edit dialog with empty member
        this.editingMember = {}
        this.showEditDialog = true
      } else {
        // Existing member: show detail view
        this.selectedMemberId = id
        this.activeItem = 'memberDetail'
      }
    },
    showMembersList() {
      this.selectedMemberId = null
      this.activeItem = 'members'
    },
    handleEditMember(member) {
        this.editingMember = member
        this.showEditDialog = true
    },
    closeEditDialog() {
        this.showEditDialog = false
        this.editingMember = null
    },
    onMemberUpdated(updatedMember) {
        // If we are in detail view, refresh it
        if (this.activeItem === 'memberDetail' && this.$refs.memberDetail) {
            this.$refs.memberDetail.fetchData()
        }
        // Ideally we would also update the list in Members.vue, but it will reload when we go back anyway because v-if destroys it? 
        // Actually Members is in v-if, so it is destroyed on switch. So it will reload fresh data when going back.
        this.closeEditDialog()
    }
  }
}
</script>

<style scoped>
.clubsuite-core-container { padding: 20px; }
</style>
