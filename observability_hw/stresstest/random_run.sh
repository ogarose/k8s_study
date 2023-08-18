#!/bin/bash

# Number of times to run the command
num_runs=10

# Command to run
command_to_run="newman run --env-var hwBaseUrl=arch.homework:80 otus_hw2.postman_collection.json"

# Function to generate a random delay
generate_random_delay() {
  min_delay=1  # Minimum delay in seconds
  max_delay=5  # Maximum delay in seconds
  echo $((RANDOM % (max_delay - min_delay + 1) + min_delay))
}

# Loop to run the command multiple times
for ((i=1; i<=$num_runs; i++)); do
  delay=$(generate_random_delay)
  echo "Running command: $command_to_run (Run $i)"
  sleep $delay
  $command_to_run
  echo "Delaying for $delay seconds..."
done