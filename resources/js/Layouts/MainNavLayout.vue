<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

import Magnify from "vue-material-design-icons/Magnify.vue";
import Home from "vue-material-design-icons/Home.vue";
import HomeOutline from "vue-material-design-icons/HomeOutline.vue";
import TelevisionPlay from "vue-material-design-icons/TelevisionPlay.vue";
import StorefrontOutline from "vue-material-design-icons/StorefrontOutline.vue";
import AccountGroup from "vue-material-design-icons/AccountGroup.vue";
import ControllerClassicOutline from "vue-material-design-icons/ControllerClassicOutline.vue";
import DotsGrid from "vue-material-design-icons/DotsGrid.vue";
import FacebookMessenger from "vue-material-design-icons/FacebookMessenger.vue";
import Bell from "vue-material-design-icons/Bell.vue";
import Logout from "vue-material-design-icons/Logout.vue";

import CropperModal from "@/Components/CropperModal.vue";
import ImageDisplay from "@/Components/ImageDisplay.vue";

// Pinia
import { useGeneralStore } from "@/stores/general";
import { storeToRefs } from "pinia";
const useGeneral = useGeneralStore();
const { isPostOverlay, isCropperModal, isImageDisplay } = storeToRefs(useGeneral);

// Bring the logged in user
const user = usePage().props.auth.user;
let showMenu = ref(false);
</script>

<template>
  <!-- 
    setup the page layout.
  
    NOTE: Start with Navbar
   -->
  <div
    id="MainNav"
    class="fixed z-50 w-full flex items-center justify-between h-[56px] bg-white shadow-xl border-b"
  >
    <!-- 
      First navigation section
      TIP: set width explicitly -->
    <div id="NavLeft" class="flex items-center justify-start w-[260px]">
      <!-- LOGO -->
      <Link href="/" class="pl-3 min-w-[55px]">
        <img src="/images/icons/FacebookLogoCircle.png" class="w-[40px]" />
      </Link>
      <!-- Outer div to input section -->
      <div
        class="flex items-center justify-center bg-[#EFF2F5] p-1 rounded-full h-[40px] ml-2"
      >
        <Magnify class="p-1" :size="22" fillColor="#64676B" />
        <!-- lg:block hidden: Hide input on screens less than 1024px and show from 1024px and larger screens  -->
        <input
          class="lg:block hidden border-none p-0 bg-[#EFF2F5] placeholder-[#64676B] ring-0 focus:ring-0"
          type="text"
          placeholder="Search Facebook"
        />
      </div>
    </div>

    <!-- 
      Second navigation section
      w-8/12 max-w-[600px]: 66% of 600px. The element will never go beyond 600px.
      - lg:flex hidden : Apply flex from 1024px and larger screens anything below hide #NavCenter
       -->
    <div
      id="NavCenter"
      class="lg:flex hidden items-center justify-center w-8/12 max-w-[600px] ml-5"
    >
      <Link href="/" class="w-full">
        <!-- 
        NOTE: h-[48px] + p-1 i.e. 4px top and 4px bottom = 56px which is height of navigation element
       -->
        <div
          :class="$page.url === '/' ? 'mt-1.5' : ''"
          class="flex items-center justify-center h-[48px] p-1 hover:bg-[#F2F2F2] w-full rounded-lg cursor-pointer"
        >
          <div>
            <Home
              v-if="$page.url === '/'"
              fillColor="#1A73E3"
              :size="27"
              class="mx-auto"
            />
            <HomeOutline v-else class="mx-auto" :size="32" fillColor="#64676B" />
          </div>
        </div>

        <!-- mimic a border bottom but with a condition to show when active -->
        <div
          v-if="$page.url === '/'"
          class="border-b-4 border-b-blue-400 rounded-md"
        ></div>
      </Link>

      <!-- NOTE: w-full will adjust accordingly for the elements to sit next to each other -->
      <button
        class="flex items-center justify-center h-[48px] p-1 hover:bg-[#F2F2F2] w-full rounded-lg mx-1 cursor-pointer"
      >
        <TelevisionPlay class="mx-auto" :size="27" fillColor="#64676B" />
      </button>
      <button
        class="flex items-center justify-center h-[48px] p-1 hover:bg-[#F2F2F2] w-full rounded-lg mx-1 cursor-pointer"
      >
        <StorefrontOutline class="mx-auto" :size="27" fillColor="#64676B" />
      </button>
      <button
        class="flex items-center justify-center h-[48px] p-1 hover:bg-[#F2F2F2] w-full rounded-lg mx-1 cursor-pointer"
      >
        <span class="rounded-full border-[2px] border-[#64676B] p-1">
          <AccountGroup class="mx-auto" :size="22" fillColor="#64676B" />
        </span>
      </button>
      <button
        class="flex items-center justify-center h-[48px] p-1 hover:bg-[#F2F2F2] w-full rounded-lg mx-1 cursor-pointer"
      >
        <ControllerClassicOutline class="mx-auto" :size="32" fillColor="#64676B" />
      </button>
    </div>

    <!-- 
      Third navigation section 
      NOTE: This section will not hide like the second one on all screens.

      TIP: is not a must w-2/12 to balance with anything else e.g. w-10/12 it's just a width
      -->
    <div class="flex items-center justify-end w-2/12 mr-4">
      <button class="rounded-full bg-[#E3E6EA] p-2 hover:bg-gray-300 mx-1 cursor-pointer">
        <DotsGrid fillColor="#050505" :size="23" />
      </button>
      <button class="rounded-full bg-[#E3E6EA] p-2 hover:bg-gray-300 mx-1 cursor-pointer">
        <FacebookMessenger fillColor="#050505" :size="23" />
      </button>
      <button class="rounded-full bg-[#E3E6EA] p-2 hover:bg-gray-300 mx-1 cursor-pointer">
        <Bell fillColor="#050505" :size="23" />
      </button>

      <div class="flex items-center justify-center relative">
        <button @click="showMenu = !showMenu">
          <!-- NOTE: 
        Element should not become smaller than the specified minimum width or taller than the specified maximum height.
        i.e. Element is perfect square
         -->
          <img
            src="https://picsum.photos/id/58/300/320"
            class="rounded-full ml-1 min-w-[40px] max-h-[40px] cursor-pointer"
          />
        </button>
        <!-- Float the menu and show it based on toggler's state -->
        <div
          v-if="showMenu"
          class="absolute bg-white shadow-xl top-10 right-0 w-[330px] rounded-lg p-1 border mt-1"
        >
          <!-- 
            If navigation happens then close the menu.
            HINT: menu items will be stacked
             -->
          <Link
            href="/"
            @click="showMenu = !showMenu"
            class="flex items-center gap-3 hover:bg-gray-300 p-2 rounded-lg"
          >
            <img
              src="https://picsum.photos/id/58/300/320"
              class="rounded-full ml-1 min-w-[35px] max-h-[35px] cursor-pointer"
            />
            <span>David Mutua</span>
          </Link>
          <Link class="w-full" :href="route('logout')" as="button" method="post">
            <div class="flex items-center gap-3 hover:bg-gray-200 px-2 py-2.5 rounded-lg">
              <Logout class="pl-2" :size="30" />
              <span>Logout</span>
            </div>
          </Link>
          <div class="text-xs font-semibold p-2 pt-3 border-t mt-1">
            Privacy . Terms . Advertising . Ad Choices . Cookies . Meta &copy; 2023
          </div>
        </div>
      </div>
    </div>
  </div>
  <slot />

  <CropperModal v-if="isCropperModal" @showModal="isCropperModal = false" />
  <ImageDisplay v-if="isImageDisplay"/>
</template>
