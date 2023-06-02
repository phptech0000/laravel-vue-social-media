<template>
  <div class="fixed z-50">
    <!-- 
    NOTE: inset-0 : set the top, right, bottom, and left positions of an element simultaneously. 
    currently it sets all four to 0 thus covers entire screen.
    
  -->
    <div class="fixed inset-0 bg-white bg-opacity-60"></div>

    <!-- TIP: incase content exceeds available height i.e. `screen` we add a scrollbar -->
    <div class="fixed inset-0 z-[10] overflow-y-auto">
      <div class="flex flex-col min-h-full justify-center items-center py-2">
        <!-- 
            NOTE: 
            - overflow-hidden: content overflowing the element's boundaries will be clipped and not visible.
            - transition-all: change slowly
           -->
        <div
          class="transform overflow-hidden rounded-lg bg-white shadow-2xl transition-all max-w-xl"
        >
          <div class="flex items-center py-4 border-b border-b-gray-300">
            <div class="text-[22px] font-extrabold w-full text-center">
              Update profile picture
            </div>
            <div
              @click="$emit('showModal', false)"
              class="absolute right-3 rounded-full p-1.5 bg-gray-200 hover:bg-gray-300 cursor-pointer"
            >
              <Close :size="28" fillColor="#5E6771" />
            </div>
          </div>

          <div class="flex items-center bg-white px-4 pb-4">
            <div>
              <div class="my-4">
                <!-- prettier-ignore -->
                <label
                  for="image"
                  class="flex items-center justify-center bg-[#E7F3FF] text-[#1977F2] 
                  hover:bg-[#DBE7F2] font-bold p-2 rounded-lg 
                  w-full cursor-pointer"
                >
                <Plus :size="20"/> Upload photo
                </label>
                <!-- TIP: Trick here by clicking the label indirectly clicks the input via "for" attribute -->
                <input
                  type="file"
                  id="image"
                  ref="fileInput"
                  class="hidden"
                  @change="getUploadedImage"
                />
              </div>

              <!-- NOTE:
                w-[350px] : automatically makes label stretch to fill the created bigger space
              -->
              <div class="w-[350px] mx-auto">
                <Cropper
                  class="object-cover"
                  ref="cropper"
                  :stencil-component="CircleStencil"
                  :src="uploadedImage"
                />
              </div>

              <!-- If there is an a loaded image -->
              <!-- prettier-ignore -->
              <div class="flex gap-4" :class="uploadedImage ? 'pt-4' : ''">
                <button
                  type="button"
                  @click="$emit('showModal', false)"
                  class="w-full justify-center rounded-md py-2 text-gray-600 
                  hover:text-gray-800 font-bold hover:bg-gray-200 
                  focus:outline-none focus:ring-0"
                >Cancel</button>

                <!-- prettier-ignore -->
                <button v-if="uploadedImage" @click="crop" type="button" 
                class="w-full rounded-md bg-blue-500 py-2 text-white font-bold 
                shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-0">
                Crop image
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

import { Cropper, CircleStencil } from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";

import Close from "vue-material-design-icons/Close.vue";
import Plus from "vue-material-design-icons/Plus.vue";

// Define Emit Event
const emit = defineEmits(["showModal"]);

let fileInput = ref(null);
let cropper = ref(null);
let uploadedImage = ref(null);

// Image Metadata
let croppedImageData = {
  file: null,
  imageUrl: null,
  height: null,
  width: null,
  left: null,
  top: null,
};

const getUploadedImage = (event) => {
  const file = event.target.files[0];
  // convert the file into an object url
  uploadedImage.value = URL.createObjectURL(file);
};

const crop = () => {
  const { coordinates, canvas } = cropper.value.getResult();
  croppedImageData.imageUrl = canvas.toDataURL();

  // Append all the coordinates to FormData object
  let data = new FormData();
  data.append("image", fileInput.value.files[0] || "");
  data.append("height", coordinates.height || "");
  data.append("width", coordinates.width || "");
  data.append("left", coordinates.left || "");
  data.append("right", coordinates.right || "");
  data.append("top", coordinates.top || "");

  // TODO: Send to Backend

  // Close the modal by emitting an event to parent component i.e. @showModal
  emit("showModal", false);
};
</script>
