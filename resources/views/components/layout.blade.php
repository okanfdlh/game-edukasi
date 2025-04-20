<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

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
          umum: [],
          matematika: [],
          polmanbabel: []
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
              alert("CSRF token tidak ditemukan.");
              return;
            }

            // Fetch kelas.json dari URL
            const kelasRes = await fetch('http://127.0.0.1:8000/kelas.json');
            if (!kelasRes.ok) {
              const errorText = await kelasRes.text();
              console.error("Fetch kelas.json gagal:", errorText);
              throw new Error("Gagal ambil kelas.json.");
            }

            const kelasData = await kelasRes.json();
            const found = kelasData.find(mhs => mhs.npm === this.npm);

            if (found) {
              this.studentData = found;

              // Kirim ke server jika valid
              const response = await fetch('/submit-npm', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ npm: this.npm })
              });

              if (!response.ok) {
                const errorText = await response.text();
                console.error("Fetch /submit-npm gagal:", errorText);
                throw new Error("Gagal kirim ke server.");
              }

              const res = await response.json();
              this.visitorCount = res.visitor_number;
              this.step = 2;

            } else {
              alert("NPM tidak ditemukan di daftar kelas.");
            }

          } catch (error) {
            alert("Gagal memproses data NPM.");
            console.error("submitNPM error:", error);
          }
        },

        nextStep() {
        this.step = 3;
      },

      async selectCategory(cat) {
      this.category = cat;
      this.step++;
      
      // Fetch questions from the server based on selected category
      try {
        const res = await fetch(`http://127.0.0.1:8000/questions/${this.category}`);
        const data = await res.json();

        // Format questions for quiz
        this.questions[this.category] = data.map(q => ({
          question: q.pertanyaan,
          options: JSON.parse(q.pilihan_jawaban), // Parse the options to an array
          answerIndex: q.jawaban_benar, // Store the correct answer index
        }));

        this.startQuiz();
      } catch (error) {
        console.error("Error fetching questions:", error);
      }
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
      
      // Get the index of the selected option
      const selectedOptionIndex = current.options.indexOf(option);
      
      // Check if the selected option index matches the correct answer index
      this.isCorrect = selectedOptionIndex === current.answerIndex;
      
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
      this.step = 2;
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
