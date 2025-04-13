<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Game Literasi Interaktif</title>

  <!-- Tailwind CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  
  <!-- Alpine.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  
  <!-- Confetti library (optional) -->
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
    /* Animasi FadeIn */
    .animate-fadeIn {
      animation: fadeIn 1s ease-in-out;
    }
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    /* Efek Parallax Sederhana */
    .parallax-bg {
      background-attachment: fixed;
      background-size: cover;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-200 via-purple-200 to-pink-200 min-h-screen flex items-center justify-center">

  <main>{{ $slot }}</main>

  <script>
    function quizApp() {
      return {
        step: 1,
        npm: '',
        visitorCount: 0,
        studentData: null,
        category: '',
        questions: {
          umum: [
            { question: "Apa warna langit?", options: ["Biru", "Merah", "Hijau"], answer: "Biru" },
            // Tambah pertanyaan lainnya
          ],
          matematika: [
            { question: "2 + 2 = ?", options: ["3", "4", "5"], answer: "4" },
          ],
          polmanbabel: [
            { question: "Polman Babel berlokasi di?", options: ["Bangka", "Jakarta", "Surabaya"], answer: "Bangka" },
          ]
        },
        currentQuestion: 0,
        timer: 10,
        timerInterval: null,
        showFeedback: false,
        isCorrect: false,
        score: 0,
        quizFinished: false,
        playerName: '',
        ranking: [],
        showLeaderboard: false,
  
        async submitNPM() {
        try {
          const res = await fetch('/kelas.json');
          const data = await res.json();

          const found = data.find(mhs => mhs.npm === this.npm);
          if (found) {
            this.studentData = found;
            this.step = 2;
            this.visitorCount = Math.floor(Math.random() * 500 + 1); // contoh visitor count random
          } else {
            alert('NPM tidak ditemukan di database.');
          }
        } catch (error) {
          console.error("Gagal memuat data kelas.json:", error);
        }
      },

      nextStep() {
        this.step++;
      },
  
        selectCategory(cat) {
          this.category = cat;
          this.step++;
          this.startQuiz();
        },
  
        startQuiz() {
          this.currentQuestion = 0;
          this.score = 0;
          this.quizFinished = false;
          this.startTimer();
        },
  
        startTimer() {
          this.timer = 10;
          this.timerInterval = setInterval(() => {
            if (this.timer > 0) {
              this.timer--;
            } else {
              clearInterval(this.timerInterval);
              this.showFeedback = true;
              this.isCorrect = false;
              setTimeout(() => this.nextQuestion(), 1500);
            }
          }, 1000);
        },
  
        submitAnswer(option) {
          clearInterval(this.timerInterval);
          const current = this.questions[this.category][this.currentQuestion];
          this.isCorrect = option === current.answer;
          if (this.isCorrect) this.score += 10;
          this.showFeedback = true;
          setTimeout(() => this.nextQuestion(), 1500);
        },
  
        nextQuestion() {
          this.showFeedback = false;
          this.currentQuestion++;
          if (this.currentQuestion < this.questions[this.category].length) {
            this.startTimer();
          } else {
            this.quizFinished = true;
          }
        },
  
          saveRanking() {
          if (!this.studentData) return;

          const newEntry = {
            name: this.studentData.nama,
            score: this.score,
          };

          this.ranking.push(newEntry);
          this.ranking.sort((a, b) => b.score - a.score);
          this.showLeaderboard = true;
        },

  
        resetQuiz() {
          this.step = 1;
          this.npm = '';
          this.playerName = '';
          this.category = '';
          this.currentQuestion = 0;
          this.quizFinished = false;
          this.showLeaderboard = false;
          this.ranking = [];
        }
      };
    }
  </script>
  

 
</body>
</html>
