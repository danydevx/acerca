<template>
  <div class="playground-section">
    <div class="box">
      <h3 class="title is-4">Text Inputs</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Text</label>
          <input class="input" type="text" placeholder="Text input">
        </div>
        <div class="column is-4">
          <label class="label">Email</label>
          <input class="input" type="email" placeholder="Email input">
        </div>
        <div class="column is-4">
          <label class="label">Password</label>
          <input class="input" type="password" placeholder="Password input">
        </div>
        <div class="column is-4">
          <label class="label">Number</label>
          <input class="input" type="number" placeholder="Number input">
        </div>
        <div class="column is-4">
          <label class="label">Tel</label>
          <input class="input" type="tel" placeholder="Telephone input">
        </div>
        <div class="column is-4">
          <label class="label">Url</label>
          <input class="input" type="url" placeholder="Url input">
        </div>
        <div class="column is-4">
          <label class="label">Search</label>
          <UiSearchInput v-model="searchValue" placeholder="Search..." />
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <input class="input" type="text" placeholder="Disabled input" disabled>
        </div>
        <div class="column is-4">
          <label class="label">With Error</label>
          <input class="input is-danger" type="text" placeholder="Error input" value="Invalid">
          <p class="help is-danger">This field has an error</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Textarea</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <textarea class="textarea" placeholder="Textarea placeholder"></textarea>
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <textarea class="textarea" placeholder="Disabled textarea" disabled></textarea>
        </div>
        <div class="column is-4">
          <label class="label">With Error</label>
          <textarea class="textarea is-danger" placeholder="Error textarea">Invalid content</textarea>
          <p class="help is-danger">This field has an error</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Select</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <div class="select">
            <select>
              <option>Select option</option>
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </div>
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <div class="select is-disabled">
            <select disabled>
              <option>Select option</option>
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </div>
        </div>
        <div class="column is-4">
          <label class="label">With Error</label>
          <div class="select is-danger">
            <select>
              <option>Select option</option>
              <option>Option 1</option>
              <option>Option 2</option>
              <option>Option 3</option>
            </select>
          </div>
          <p class="help is-danger">This field has an error</p>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Checkbox</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Single</label>
          <input type="checkbox" id="checkbox1">
          <label for="checkbox1">Accept terms</label>
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <input type="checkbox" id="checkbox2" disabled checked>
          <label for="checkbox2">Disabled checkbox</label>
        </div>
        <div class="column is-4">
          <label class="label">Group</label>
          <div class="field">
            <label class="checkbox">
              <input type="checkbox"> Option 1
            </label>
          </div>
          <div class="field">
            <label class="checkbox">
              <input type="checkbox"> Option 2
            </label>
          </div>
          <div class="field">
            <label class="checkbox">
              <input type="checkbox"> Option 3
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Radio</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Single</label>
          <input type="radio" id="radio1" name="radio-single">
          <label for="radio1">Yes</label>
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <input type="radio" id="radio2" name="radio-disabled" disabled checked>
          <label for="radio2">Disabled radio</label>
        </div>
        <div class="column is-4">
          <label class="label">Group</label>
          <div class="field">
            <label class="radio">
              <input type="radio" name="radio-group"> Option 1
            </label>
          </div>
          <div class="field">
            <label class="radio">
              <input type="radio" name="radio-group"> Option 2
            </label>
          </div>
          <div class="field">
            <label class="radio">
              <input type="radio" name="radio-group"> Option 3
            </label>
          </div>
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Switch</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <UiSwitch v-model="switchValue" label="Enable notifications" />
        </div>
        <div class="column is-4">
          <label class="label">Checked</label>
          <UiSwitch v-model="switchChecked" label="Active switch" />
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <UiSwitch v-model="switchDisabled" label="Disabled switch" disabled />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Range Input</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <UiRangeInput v-model="rangeValue" :min="0" :max="100" :step="1" />
        </div>
        <div class="column is-4">
          <label class="label">With Value</label>
          <UiRangeInput v-model="rangeValue2" :min="0" :max="100" :step="1" showValue />
        </div>
        <div class="column is-4">
          <label class="label">With Min/Max</label>
          <UiRangeInput v-model="rangeValue3" :min="0" :max="100" :step="1" showValue showMinMax />
        </div>
        <div class="column is-4">
          <label class="label">Disabled</label>
          <UiRangeInput v-model="rangeDisabled" :min="0" :max="100" :step="1" showValue disabled />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Segmented Control</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <UiSegmentedControl v-model="segmentedValue" :options="segmentedOptions" />
        </div>
        <div class="column is-4">
          <label class="label">Grid Variant</label>
          <UiSegmentedControl v-model="segmentedValue2" :options="segmentedOptions" variant="grid" />
        </div>
        <div class="column is-4">
          <label class="label">Compact Variant</label>
          <UiSegmentedControl v-model="segmentedValue3" :options="segmentedOptions" variant="compact" />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">File Input</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <UiFileInput v-model="fileValue" accept="image/*" />
        </div>
        <div class="column is-4">
          <label class="label">Multiple</label>
          <UiFileInput v-model="fileValue2" accept="image/*" multiple />
        </div>
        <div class="column is-4">
          <label class="label">With Error</label>
          <UiFileInput v-model="fileValue3" accept="image/*" error="File type not allowed" />
        </div>
      </div>
    </div>

    <div class="box">
      <h3 class="title is-4">Image Input with Preview</h3>
      <div class="columns is-multiline">
        <div class="column is-4">
          <label class="label">Default</label>
          <UiImageInput v-model="imageValue" />
        </div>
        <div class="column is-4">
          <label class="label">With Image</label>
          <UiImageInput v-model="imageValueWithSrc" />
        </div>
        <div class="column is-4">
          <label class="label">With Error</label>
          <UiImageInput v-model="imageValueError" error="Image is required" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import UiSearchInput from '@/Components/Ui/SearchInput.vue'
import UiRangeInput from '@/Components/Ui/RangeInput.vue'
import UiFileInput from '@/Components/Ui/FileInput.vue'
import UiSegmentedControl from '@/Components/Ui/SegmentedControl.vue'
import UiSwitch from '@/Components/Ui/UiSwitch.vue'
import UiImageInput from '@/Components/Ui/ImageInput.vue'

const searchValue = ref('')
const switchValue = ref(false)
const switchChecked = ref(true)
const switchDisabled = ref(true)
const rangeValue = ref(50)
const rangeValue2 = ref(75)
const rangeValue3 = ref(25)
const rangeDisabled = ref(50)
const segmentedValue = ref('week')
const segmentedValue2 = ref('month')
const segmentedValue3 = ref('day')
const fileValue = ref([])
const fileValue2 = ref([])
const fileValue3 = ref([])
const imageValue = ref('')
const imageValueWithSrc = ref('https://picsum.photos/200/150')
const imageValueError = ref('')

const segmentedOptions = [
  { value: 'day', label: 'Day' },
  { value: 'week', label: 'Week' },
  { value: 'month', label: 'Month' },
  { value: 'year', label: 'Year' }
]
</script>
