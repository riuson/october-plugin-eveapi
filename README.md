# october-plugin-eveapi
Interface to get data from EVE API server

Example:

        // keyID, vCode, characterID
        $userCredentials = new EveApiUserData(12345678, 'HDbjhBWJDHwbdBw..', 1234498798);
        $methodInfo = EveApiCallsLibrary::char_skillTraining();
        $caller = new EveApiCaller($methodInfo, array(), $userCredentials);
        $answer = $caller->call();

        if ($answer instanceof FailedCall) {
            $key->errorCode = $answer->errorCode;
            $key->errorText = $answer->errorText;
            $key->valid = false;
            $key->save();
        } else {
            // user object to save data
            $skillTraining = SkillTrainingModel::firstOrCreate([
                'character_id' => $character->characterID
            ]);
            
            // fill data
            $skillTraining->skillInTraining = $answer->values->byName('skillInTraining');

            if ($skillTraining->skillInTraining != 0) {
                $skillTraining->trainingEndTime = $answer->values->byName('trainingEndTime');
                $skillTraining->trainingStartTime = $answer->values->byName('trainingStartTime');
                $skillTraining->trainingTypeID = $answer->values->byName('trainingTypeID');
                $skillTraining->trainingStartSP = $answer->values->byName('trainingStartSP');
                $skillTraining->trainingDestinationSP = $answer->values->byName('trainingDestinationSP');
                $skillTraining->trainingToLevel = $answer->values->byName('trainingToLevel');
            } else {
                $skillTraining->trainingTypeID = 0;
            }
            
            // save
            $skillTraining->save();
        }
