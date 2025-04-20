<x-layout>
    <div x-data="quizApp()" class="p-6 max-w-2xl mx-auto text-center bg-white rounded-3xl shadow-xl animate-fadeIn">
      <h1 class="text-5xl font-bold mb-8 bg-gradient-to-r from-indigo-500 via-pink-500 to-yellow-500 text-transparent bg-clip-text animate-bounce">
        Game Literasi Interaktif
      </h1>
  
      <!-- 1. Input NPM -->
      <template x-if="step === 1">
        <div>
          <h2 class="text-2xl mb-4 font-semibold">Masukkan NPM</h2>
          <input type="text" x-model="npm" class="border p-3 rounded-xl w-full text-center shadow" placeholder="Contoh: 1062260">
          <button @click="submitNPM()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-xl w-full shadow transition">Lanjut</button>
        </div>
      </template>
  
      <!-- 2. Menampilkan info pengunjung -->
      <template x-if="step === 2">
        <div class="animate-fadeIn">
          <h2 class="text-2xl mb-2 font-semibold text-green-700">Selamat datang!</h2>
          <p class="text-lg mb-1">Halo, <span x-text="studentData.nama"></span> (NPM: <span x-text="npm"></span>)</p>
          <p class="text-lg mb-4">Anda adalah pengunjung ke-<span x-text="visitorCount"></span></p>
          <button @click="nextStep()" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-2 rounded-xl shadow">Lanjut</button>
        </div>
      </template>

      <!-- 4. Pilih Kategori Soal -->
      <template x-if="step === 3">
        <div>
          <h2 class="text-2xl mb-4 font-semibold">Pilih Kategori Kuis</h2>
          <div class="grid grid-cols-1 gap-4">
            <button @click="selectCategory('umum')" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-2xl shadow-lg transition transform hover:scale-105">Umum</button>
            <button @click="selectCategory('matematika')" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-2xl shadow-lg transition transform hover:scale-105">Matematika</button>
            <button @click="selectCategory('polmanbabel')" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-2xl shadow-lg transition transform hover:scale-105">Kampus Polman Babel</button>
          </div>
        </div>
      </template>
  
      <!-- 5. Kuis -->
      <template x-if="category && !quizFinished">
        <div class="animate-fadeIn">
          <h2 class="text-3xl mb-4 font-semibold">Pertanyaan <span x-text="currentQuestion + 1"></span></h2>
          <p class="mb-2 text-xl text-gray-600">Sisa waktu: <span class="font-bold text-red-500" x-text="timer"></span> detik</p>
          <p class="mb-6 text-2xl font-medium bg-yellow-100 p-4 rounded-xl shadow" x-text="questions[category][currentQuestion].question"></p>
          <div class="space-y-4">
            <template x-for="(option, index) in questions[category][currentQuestion].options" :key="index">
              <button @click="submitAnswer(option)" class="block w-full text-left border p-4 rounded-2xl hover:bg-gray-200 shadow transition transform hover:scale-105" :disabled="showFeedback">
                <span x-text="option"></span>
              </button>
            </template>
          </div>
          <div x-show="showFeedback" x-transition class="mt-4 p-4 rounded-2xl text-xl font-bold shadow" :class="isCorrect ? 'bg-green-300 text-green-900' : 'bg-red-300 text-red-900'">
            <span x-text="isCorrect ? 'Jawaban benar!' : 'Jawaban salah atau waktu habis!'"></span>
          </div>
        </div>
      </template>
  
      <!-- 6. Tampilkan Nilai -->
      <template x-if="quizFinished && !showLeaderboard">
        <div class="animate-fadeIn">
          <h2 class="text-4xl font-bold mb-4 text-green-700">Skor Anda: <span x-text="score"></span></h2>
          <button @click="saveRanking()" class="bg-yellow-500 hover:bg-yellow-600 text-white p-4 rounded-2xl w-full mb-4 shadow-lg transition transform hover:scale-105">
            Simpan Ranking & Lihat Statistik
          </button>

        </div>
      </template>
  
      <!-- 7. Leaderboard / Statistik -->
      <template x-if="showLeaderboard && ranking.length > 0">
        <div class="mt-10 animate-fadeIn">
          <h2 class="text-3xl font-bold mb-4 text-indigo-700">Statistik & Leaderboard</h2>
          <ul class="text-left bg-gray-50 p-4 rounded-2xl shadow">
            <template x-for="(entry, index) in ranking" :key="index">
              <li class="mb-2 text-xl font-medium">
                <span x-text="index + 1"></span>. <span x-text="entry.name"></span> - <span class="font-bold" x-text="entry.score"></span> poin
              </li>
            </template>
          </ul>
          <button @click="resetQuiz()" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white p-3 rounded-2xl shadow-lg transition transform hover:scale-105">
            Main Lagi
          </button>
        </div>
      </template>
  
      {{-- <footer class="mt-10 text-gray-500 text-sm"></footer> --}}
    </div>
  </x-layout>
  