<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mood Check-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .mood-selector {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            max-width: 500px;
            margin-bottom: 20px;
        }

        .mood-selector input[type="radio"] {
            display: none;
        }

        .mood-selector label {
            cursor: pointer;
            border-radius: 50%;
            overflow: hidden;
            width: 70px;
            height: 70px;
            display: inline-block;
            border: 3px solid transparent;
            transition: border 0.2s ease, transform 0.2s ease;
        }

        .mood-selector label img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .mood-selector input[type="radio"]:checked+label {
            border-color: rgba(177, 241, 148, 0.979);
            transform: scale(1.1);
        }

        .mood-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 50%;
        }

        textarea {
            display: block;
            width: 100%;
            height: 100px;
            resize: vertical;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="card p-4 shadow-sm mood-container">
                    <h2 class="mb-4">🧠 Mood Check-In</h2>
                    <form method="POST" action="">

                        <div class="mb-3">
                            <label class="form-label">How are you feeling today?</label>
                            <div class="mood-selector">
                                <input type="radio" id="happy_jae" name="mood_type" value="happy">
                                <label for="happy_jae">
                                    <img src="assets/image/jae.png" alt="Happy - Jaehyun" title="Happy - Jaehyun"
                                        data-bs-toggle="tooltip" data-bs-placement="top" class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="relieved_jun" name="mood_type" value="relieved">
                                <label for="relieved_jun">
                                    <img src="assets/image/chilljun.png" alt="Motivated - Xiaojun"
                                        title="Relieved - Xiaojun" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="motivated_mark" name="mood_type" value="motivated">
                                <label for="motivated_mark">
                                    <img src="assets/image/markmot.png" alt="Motivated - Mark" title="Motivated - Mark"
                                        data-bs-toggle="tooltip" data-bs-placement="top" class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="sad_renjun" name="mood_type" value="sad">
                                <label for="sad_renjun">
                                    <img src="assets/image/rjsad.png" alt="Sad - Renjun" title="Sad - Renjun"
                                        data-bs-toggle="tooltip" data-bs-placement="top" class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="stressed_nana" name="mood_type" value="stressed">
                                <label for="stressed_nana">
                                    <img src="assets/image/nanastress.png" alt="Stressed - Jaemin"
                                        title="Stressed - Jaemin" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>

                                <input type="radio" id="scared_doyoung" name="mood_type" value="scared">
                                <label for="scared_doyoung">
                                    <img src="assets/image/doyscared.png" alt="Scared - Doyoung"
                                        title="Scared - Doyoung" data-bs-toggle="tooltip" data-bs-placement="top"
                                        class="mood-img img-fluid" />
                                </label>
                            </div>
                        </div>

                         <div class="mb-3">
                <label for="userNote" class="form-label">Add your thoughts (optional)</label>
                <textarea class="form-control" name="user_note" id="userNote" rows="3"></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Share</button>
            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>